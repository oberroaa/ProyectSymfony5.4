<?php

namespace App\Repository;

use App\Entity\BuildingPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingPlayer[]    findAll()
 * @method BuildingPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingPlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingPlayer::class);
    }

    // /**
    //  * @return BuildingPlayer[] Returns an array of BuildingPlayer objects
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
    public function findOneBySomeField($value): ?BuildingPlayer
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
