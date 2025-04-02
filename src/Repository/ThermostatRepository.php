<?php

namespace App\Repository;

use App\Entity\Thermostat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Thermostat>
 */
class ThermostatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thermostat::class);
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
    //     * @return Thermostat[] Returns an array of Thermostat objects
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

    //    public function findOneBySomeField($value): ?Thermostat
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
