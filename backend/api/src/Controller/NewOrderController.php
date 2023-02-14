<?php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\OrderDetails;
use App\Service\StripeService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class NewOrderController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private ValidatorInterface $validator,
        private Security $security,
        private StripeService $stripeService
    ) {}

    public function __invoke()
    {
        

        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();
        $body = json_decode($request->getContent(),true);
        $date = new \DateTime();
        $order = new Order();
        $reference = $date->format('dmY').'-'.uniqid();
        $order->setReference($reference);
        $order->setCustomer($this->security->getUser());
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
            // GET TOTAL PRICE FOR EACH ORDERITEM AND SET THE ORDERDETAILS
            $findItem = $em->getRepository(Product::class)->findOneById($item['itemId']);
            $findItem->setStockQuantity($findItem->getStockQuantity() - $item['quantity']);
            $orderDetails = new OrderDetails;
            $orderDetails->setMyOrder($order);
            $orderDetails->setItem($findItem);
            $orderDetails->setQuantity($item['quantity']);
            $orderDetails->setTotalPrice($findItem->getPrice());
            $orderDetails->setState(0);
            $em->persist($orderDetails);
            
            $total += $orderDetails->getTotalPrice()*$orderDetails->getQuantity();

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

       

        $response = new Response();
        $response->setContent(json_encode(array("stripeSessionId"=>$order->getStripeSessionId())));
        return $response;
    }
}