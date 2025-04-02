<?php

namespace App\Repository;

use App\Entity\ReservationJeux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservationJeux>
 */
class ReservationJeuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationJeux::class);
    }

//    /**
//     * @return ReservationJeux[] Returns an array of ReservationJeux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('rj')
//            ->andWhere('rj.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('rj.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReservationJeux
//    {
//        return $this->createQueryBuilder('rj')
//            ->andWhere('rj.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
