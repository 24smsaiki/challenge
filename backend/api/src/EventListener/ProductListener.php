<?php

namespace App\EventListener;

use App\Entity\Seller;
use App\Entity\Product;
use Doctrine\ORM\Events;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ProductListener implements EventSubscriberInterface
{
    
    public function __construct(private TokenStorageInterface $tokenStorage, private ManagerRegistry $managerRegistry){}

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist($args): void
    {
        if ($args instanceof Product) {
            $seller = $this->managerRegistry->getManager()->getRepository(Seller::class)->findOneByUserId($this->tokenStorage->getToken()->getUser()->getId());
            $args->setSeller($seller);
        }
    
    }

}


