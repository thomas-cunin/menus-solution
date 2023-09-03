<?php

namespace App\Repository;

use App\Entity\PriceQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PriceQuantity>
 *
 * @method PriceQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceQuantity[]    findAll()
 * @method PriceQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceQuantityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceQuantity::class);
    }

//    /**
//     * @return PriceQuantity[] Returns an array of PriceQuantity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PriceQuantity
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
