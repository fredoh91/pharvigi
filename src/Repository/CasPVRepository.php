<?php

namespace App\Repository;

use App\Entity\CasPV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CasPV>
 */
class CasPVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CasPV::class);
    }

//    /**
//     * @return CasPV[] Returns an array of CasPV objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CasPV
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    
    // /**
    //  * Récupère les statuts d'un cas PV triés par createdAt
    //  * 
    //  * @param int $casId L'ID du cas PV
    //  * @param string $sensTri Le sens du tri (ASC ou DESC)
    //  * @return array Les statuts triés
    //  */
    // public function findStatutCasPVsOrderedByCreatedAt(int $casId, string $sensTri = 'DESC'): array
    // {
    //     // Vérification du sens de tri
    //     $sensTri = strtoupper($sensTri);
    //     if ($sensTri !== 'ASC' && $sensTri !== 'DESC') {
    //         $sensTri = 'DESC';
    //     }
        
    //     return $this->createQueryBuilder('c')
    //         ->leftJoin('c.statutCasPVs', 'sc')
    //         ->where('c.id = :casId')
    //         ->setParameter('casId', $casId)
    //         ->orderBy('sc.CreatedAt', $sensTri)
    //         ->getQuery()
    //         ->getResult();
    // }
}
