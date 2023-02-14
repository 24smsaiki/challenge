<?php

namespace App\Extension;


use App\Entity\Order;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use function PHPSTORM_META\map;

/**
 * This extension makes sure normal users can only access their own Orders
 */
final class CurrentUserOrdersExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
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
        if (Order::class !== $resourceClass) {
            return;
        }

        // share operation between users and admin role
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $user = $this->securityChecker->getUser();
        if(null === $user){
            return;
        }
        
        // only with state pending
        if ($this->securityChecker->isGranted('ROLE_ADMIN')) {
            $state = 0;
            $queryBuilder
                ->select($rootAlias)
                ->where('o.state = :state')
                ->setParameter('state', $state)
            ;    
            return;
        }

        // here the orders for the users (select only those passed by the current user)
        if($this->securityChecker->isGranted('ROLE_USER')){
            $queryBuilder->andWhere(sprintf('%s.customer = :current_user', $rootAlias));
            $queryBuilder->setParameter('current_user', $user); 
            
            return;
        }

    }
}