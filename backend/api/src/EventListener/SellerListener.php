<?php

namespace App\EventListener;

use App\Entity\Seller;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SellerListener implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack, private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist($args): void
    {
        if ($args instanceof Seller) {
            $request = $this->requestStack->getCurrentRequest();
            $content = json_decode($request->getContent(), true);

            $hashedPassword = $this->passwordHasher->hashPassword($args, $content['password']);
            $args->setPassword($hashedPassword);
        }
    }
}
