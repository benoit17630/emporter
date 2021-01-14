<?php

namespace App\Repository\Admin;

use App\Entity\Admin\BasePizza;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BasePizza|null find($id, $lockMode = null, $lockVersion = null)
 * @method BasePizza|null findOneBy(array $criteria, array $orderBy = null)
 * @method BasePizza[]    findAll()
 * @method BasePizza[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasePizzaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BasePizza::class);
    }

    // /**
    //  * @return BasePizza[] Returns an array of BasePizza objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BasePizza
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
