<?php
namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\OrderReturn;
use App\Entity\OrderDetails;
use App\Service\UserService;
use Stripe\Checkout\Session;
use App\Entity\OrderDetailsReturn;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class OrderReturnController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private ValidatorInterface $validator,
        private UserService $userService
    ) {}

  
    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();
        $body = json_decode($request->getContent(),true);

        $order = $this->managerRegistry->getManager()->getRepository(Order::class)->findOneByReference($body['orderReference']);
        $returnOrder = new OrderReturn();
        $returnOrder->setReference('return-'.uniqid());
        $returnOrder->setMyOrder($order);
        
        foreach ($body['itemsToReturn'] as $item)
        {
            $findItem = $em->getRepository(Product::class)->findOneById($item['itemId']);
            $orderDetailsReturn = new OrderDetailsReturn();
            $orderDetailsReturn->setMyOrderReturn($returnOrder);
            $orderDetailsReturn->setItem($findItem);
            $orderDetailsReturn->setReason($item['reason']);
            
            $em->persist($orderDetailsReturn);

        }    
        
        $returnOrder->setState(1);
        
        $em->persist($returnOrder);
        $em->flush();


        return new JsonResponse(['message' => 'order return added.', 'status' => 'success'], 201);

        
    }
}