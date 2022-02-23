<?php

namespace App\Repository;

use App\Entity\BiuldingConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BiuldingConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method BiuldingConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method BiuldingConfig[]    findAll()
 * @method BiuldingConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiuldingConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BiuldingConfig::class);
    }

    // /**
    //  * @return BiuldingConfig[] Returns an array of BiuldingConfig objects
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
    public function findOneBySomeField($value): ?BiuldingConfig
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
