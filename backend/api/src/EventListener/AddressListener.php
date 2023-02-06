<?php

namespace App\EventListener;

use App\Entity\Address;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class AddressListener implements EventSubscriberInterface
{
    
    public function __construct(private TokenStorageInterface $tokenStorage){}

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist($args): void
    {
        if ($args instanceof Address) {
            
            $args->setCustomer($this->tokenStorage->getToken()->getUser());
        }
    
    }

}


