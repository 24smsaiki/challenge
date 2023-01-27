<?php

namespace App\Repository;

use App\Entity\OrderDetailsReturn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderDetailsReturn>
 *
 * @method OrderDetailsReturn|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetailsReturn|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetailsReturn[]    findAll()
 * @method OrderDetailsReturn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetailsReturnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetailsReturn::class);
    }

    public function save(OrderDetailsReturn $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderDetailsReturn $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OrderDetailsReturn[] Returns an array of OrderDetailsReturn objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderDetailsReturn
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
