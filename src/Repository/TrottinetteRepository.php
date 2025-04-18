<?php

namespace App\Repository;

use App\Entity\Trottinette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trottinette>
 */
class TrottinetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trottinette::class);
    }

    public function findByBatterieFaible()
    {
        return $this->createQueryBuilder('v')
            ->where('v.niveauBatterie < :niveauBatterie')
            ->setParameter('niveauBatterie', 30)
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Trotinettes[] Returns an array of Trotinettes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Trotinettes
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
