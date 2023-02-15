<?php
namespace App\Controller;

use DateTime;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Product;
use App\Entity\OrderReturn;
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

    ) {}

  
    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();
        $body = json_decode($request->getContent(),true);
        $now = new DateTime();
        
        $order = $em->getRepository(Order::class)->findOneByReference($body['orderReference']);
        
        
        if($order->getState() === 5 && $order->getIsPaid() === true ){
            
            

            $returnOrder = new OrderReturn();
            $returnOrder->setReference('return-'.uniqid());
            $returnOrder->setMyOrder($order);
            $returnOrder->setCreatedAt($now);
            
            foreach ($body['itemsToReturn'] as $item)
            {
                // set the total of the orderReturn first
                $returnOrder->setTotalPrice($item["totalPrice"]);
                
                $orderDetailsConcerned =  $em->getRepository(OrderDetails::class)->findOneById($item["idOrderDetailsConcerned"]);
                // set the state of the order details those concern the orderReturn 
                $orderDetailsConcerned->setState(1);
                $em->persist($orderDetailsConcerned);
                $em->flush();
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
        else 
        {
            return new JsonResponse(['message' => 'Impossible d\'éffectuer un retour sur une commande pas livré !', 'status' => 'success'], 422);
        }

        
    }
}