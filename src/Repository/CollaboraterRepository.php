<?php

namespace App\Repository;

use App\Entity\Collaborater;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collaborater|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaborater|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaborater[]    findAll()
 * @method Collaborater[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboraterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collaborater::class);
    }

    // /**
    //  * @return Collaborater[] Returns an array of Collaborater objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Collaborater
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
