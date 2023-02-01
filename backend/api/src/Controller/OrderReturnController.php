<?php
namespace App\Controller;

use App\Entity\Order;
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

        $order = $this->managerRegistry->getManager()->getRepository(Order::class)->findOneByReference($body['orderReference']);
        if($order->getState() === 5 && $order->getIsPaid() === true ){
            
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
        } else {
            return new JsonResponse(['message' => 'unable to create a return for not received order', 'status' => 'success'], 201);
        }

        
    }
}