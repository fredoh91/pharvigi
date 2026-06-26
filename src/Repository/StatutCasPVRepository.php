<?php

namespace App\Repository;

use App\Entity\StatutCasPV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatutCasPV>
 */
class StatutCasPVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutCasPV::class);
    }

    public function isStatutActifIsBrouillon(\App\Entity\CasPV $casPV): bool
    {
        $result = $this->createQueryBuilder('s')
            ->andWhere('s.casPV = :casPV')
            ->setParameter('casPV', $casPV)
            ->andWhere('s.StatutActif = :statutActif')
            ->setParameter('statutActif', true)
            ->andWhere('s.LibStatut = :libStatut')
            ->setParameter('libStatut', 'brouillon')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        
        return $result !== null;
    }
    //    /**
    //     * @return StatutCasPV[] Returns an array of StatutCasPV objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?StatutCasPV
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
