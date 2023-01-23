<?php

namespace App\Extension;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Order;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * This extension makes sure normal users can only access their own Orders
 */
final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $authorizationChecker;
    
    public function __construct(private AuthorizationCheckerInterface $authChecker)
    {
        $this->authorizationChecker = $authChecker;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param string|null $operationName
     */
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        dd("hello");
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param array $identifiers
     * @param string|null $operationName
     * @param array $context
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
        dd("hello");
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $resourceClass
     *
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (Order::class !== $resourceClass
            || $this->authorizationChecker->isGranted('ROLE_ADMIN')
            || null === $user = $this->authorizationChecker->getUser()
        ) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->join(sprintf('%s.users', $rootAlias), 'users')
            ->andWhere('users.id = :user')
            ->setParameter('user', $this->authorizationChecker->getUser()->getId());
    }
}