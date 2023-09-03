<?php

namespace App\Repository;

use App\Entity\DishOrDrink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DishOrDrink>
 *
 * @method DishOrDrink|null find($id, $lockMode = null, $lockVersion = null)
 * @method DishOrDrink|null findOneBy(array $criteria, array $orderBy = null)
 * @method DishOrDrink[]    findAll()
 * @method DishOrDrink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DishOrDrinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DishOrDrink::class);
    }

//    /**
//     * @return DishOrDrink[] Returns an array of DishOrDrink objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DishOrDrink
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
