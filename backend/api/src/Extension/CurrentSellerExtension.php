<?php

namespace App\Extension;

use App\Entity\Seller;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;

final class CurrentSellerExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
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
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
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
        if (
            Seller::class !== $resourceClass
            || $this->securityChecker->isGranted('ROLE_ADMIN')
        ) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $user = $this->securityChecker->getUser();

        if (null === $user) {
            return;
        }
        // here current seller informations (shop informations)
        if ($this->securityChecker->isGranted('ROLE_SELLER')) {
            $queryBuilder
                ->select($rootAlias)
                ->where('o.userId = :current_user_id')
                ->setParameter('current_user_id', $user->getId());
            return;
        }
    }
}
