<?php
namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\OrderDetails;
use App\Service\StripeService;
use App\Service\UserService;
use Stripe\Checkout\Session;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class OrderController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private ValidatorInterface $validator,
        private UserService $userService,
        private StripeService $stripeService
    ) {}

    public function __invoke()
    {
        

        $currentUser = $this->userService->getCurrent();
        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();
        $body = json_decode($request->getContent(),true);
        $date = new \DateTime();
        $order = new Order();
        $reference = $date->format('dmY').'-'.uniqid();
        $order->setReference($reference);
        $order->setCustomer($currentUser);
        $order->setCreatedAt($date);
        $delivery = $em->getRepository(Address::class)->findOneById($body['deliveryId']);
        $carrier =  $em->getRepository(Carrier::class)->findOneById($body['carrierId']);
        $order->setDelivery($delivery);
        $order->setCarrier($carrier);
        $order->setIsPaid(0);
        $order->setState(0);

        $em->persist($order);
        $total = 0;
        $products_for_stripe =[];

        foreach ($body['orderItems'] as $item)
        {
            $findItem = $em->getRepository(Product::class)->findOneById($item['itemId']);
            $orderDetails = new OrderDetails;
            $orderDetails->setMyOrder($order);
            $orderDetails->setItem($findItem);
            $orderDetails->setQuantity($item['quantity']);
            $orderDetails->setTotalPrice($findItem->getPrice()*$orderDetails->getQuantity());
            $em->persist($orderDetails);
            
            $total += $orderDetails->getTotalPrice();

            //set products to stripe
            $products_for_stripe[] = [
                'price_data' => [
                  'currency' => 'eur',
                  'unit_amount' => ceil($orderDetails->getTotalPrice()*100),
                  'product_data' => [
                    'name' => $orderDetails->getItem()->getLabel(),
                    
                  ],
                ],
                'quantity' => $orderDetails->getQuantity(),
            ];
            

        }
        $order->setTotal($total+$order->getCarrier()->getFees());
        $em->persist($order);

        $stripeId = $this->stripeService->getSessionId($order,$products_for_stripe);

        $order->setStripeSessionId($stripeId);
        $em->flush();

       

        return new JsonResponse(['message' => 'order added.', 'status' => 'success'], 201);
    }
}