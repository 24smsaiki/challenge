<?php

namespace App\Extension;


use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use App\Entity\OrderDetails;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints\IsFalse;

/**
 * This extension makes sure normal users can only access their own Orders
 */
final class CurrentUserOrderDetailsExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $securityChecker;
    public function __construct(Security $security)
    {
        $this->securityChecker = $security;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param Operation $operation
     * @param array $context
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []) : void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param array $identifiers
     * @param Operation $operation
     * @param array $context
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        return;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $resourceClass
     *
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (OrderDetails::class !== $resourceClass){
            return;
        }

        // share operation between user and seller
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $user = $this->securityChecker->getUser();
        
        if(null === $user){
            return;
        }
        // here select only those product's published by the current seller
        if($this->securityChecker->isGranted('ROLE_SELLER'))
        {
            $queryBuilder
                ->select($rootAlias)    
                ->distinct(false)
                ->groupBy('o.myOrder')
                ->innerJoin('o.item', 'p')
                ->innerJoin('p.publisher','s')
                ->where('s.userId = :current_user_id')
                ->setParameter('current_user_id', $user->getId())
            ;
            return;
        }
        
        if ($this->securityChecker->isGranted('ROLE_ADMIN') ||  $this->securityChecker->isGranted('ROLE_USER')) {
            return;
        }
    }
}