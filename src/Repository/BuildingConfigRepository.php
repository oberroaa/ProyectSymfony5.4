<?php

namespace App\Repository;

use App\Entity\BuildingConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingConfig[]    findAll()
 * @method BuildingConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingConfig::class);
    }

    // /**
    //  * @return BuildingConfig[] Returns an array of BuildingConfig objects
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
    public function findOneBySomeField($value): ?BuildingConfig
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
