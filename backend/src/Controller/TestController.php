<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class TestController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke() : Order 
    { 
        $order = new Order();
        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();

        $body = json_decode($request->getContent());
        $reference = $body->reference;
        $idOwner = $body->owner;
        $owner = $em->getRepository(User::class)->findOneBy(['id'=>$idOwner]);
        $order->setReference($reference);
        $order->setUser($owner);
        
        return $order;
    }
}