<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Product;
use App\Entity\OrderDetails;
use App\Service\UserService;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    private $userService;
    private $entityManager;
    public function __construct(UserService $userService, EntityManagerInterface $entityManager)
    {
        $this->userService = $userService;
        $this->entityManager = $entityManager;
    }

    #[Route('/order', name: 'app_order',methods: ['GET','POST'])]
    public function index(Request $request)
    {
        $currentUser = $this->userService->getCurrent();

        $body = json_decode($request->getContent(),true);
        $date = new \DateTime();
        $order = new Order();
        $reference = $date->format('dmY').'-'.uniqid();
        $order->setReference($reference);
        $order->setUser($currentUser);
        $order->setCreatedAt($date);
        $delivery = $this->entityManager->getRepository(Address::class)->findOneById($body['delivery']);
        $order->setDelivery($delivery);
        $order->setIsPaid(0);
        $order->setState(0);

        $this->entityManager->persist($order);
        $total = 0;
        foreach ($body['orderItems'] as $item)
        {
            $orderDetails = new OrderDetails;
            $orderDetails->setMyOrder($order);
            $orderDetails->setProductName($item['title']);
            $orderDetails->setPrice($item['price']);
            $orderDetails->setQuantity($item['quantity']);
            $orderDetails->setTotal($item['price']*$item['quantity']);
            $item = $this->entityManager->getRepository(Product::class)->findOneById($item['itemId']);
            $orderDetails->setItem($item);
            $this->entityManager->persist($orderDetails);
            
            $total += $orderDetails->getTotal();


        }
        
        $order->setTotal($total);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return new Response("order Added");
    }
       
     
}
