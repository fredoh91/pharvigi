<?php

namespace App\Repository;

use App\Entity\ListeCSP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeCSP>
 */
class ListeCSPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeCSP::class);
    }



        /**
         * Retourne un tableau de ListeCSP filtré par le type de CSP, trié par date décroissante.
         * cette fonction permettra d'alimenter le champ dateCSP des formulaires CMType, EMMType et SIMADType
         *
         * @param string $TypeCSP - pour CM et EMM 'CSP_SIGNAL' et pour SIMAD 'CSP_SIMAD'
         * @param int $maxResults - nombre maximum de résultats
         * @return ListeCSP[] Retourne un tableau de ListeCSP
         */
        public function findByTypeCSP(string $TypeCSP, int $maxResults = 10): array
        {
            return $this->createQueryBuilder('l')
                ->andWhere('l.TypeCSP = :val')
                ->setParameter('val', $TypeCSP)
                ->andWhere('l.FlInactive = false')
                ->orderBy('l.DateCSP', 'DESC')
                ->setMaxResults($maxResults)
                ->getQuery()
                ->getResult()
            ;
        }


        /**
         * Retourne un QueryBuilder de ListeCSP filtré par le type de CSP, trié par date décroissante.
         * Cette méthode est utilisée par l'option query_builder de EntityType dans les formulaires
         * CMType, EMMType et SIMADType.
         *
         * @param string $TypeCSP - pour CM et EMM 'CSP_SIGNAL' et pour SIMAD 'CSP_SIMAD'
         * @param int $maxResults - nombre maximum de résultats
         * @return \Doctrine\ORM\QueryBuilder
         */
        public function findDatesCSPQueryBuilderByTypeCSP(string $TypeCSP, int $maxResults = 10): \Doctrine\ORM\QueryBuilder
        {
            return $this->createQueryBuilder('l')
                ->andWhere('l.TypeCSP = :val')
                ->setParameter('val', $TypeCSP)
                ->andWhere('l.FlInactive = false')
                ->orderBy('l.DateCSP', 'DESC')
                ->setMaxResults($maxResults)
            ;
        }

        /**
         * Retourne un tableau de dates CSP filtré par le type de CSP, trié par date décroissante.
         * Cette fonction permet de récupérer uniquement les dates CSP pour alimenter les formulaires
         *
         * @param string $TypeCSP - pour CM et EMM 'CSP_SIGNAL' et pour SIMAD 'CSP_SIMAD'
         * @param int $maxResults - nombre maximum de résultats
         * @return array Tableau de dates CSP
         */
        public function findDatesCSPByTypeCSP(string $TypeCSP, int $maxResults = 10): array
        {
            $results = $this->createQueryBuilder('l')
                ->andWhere('l.TypeCSP = :val')
                ->setParameter('val', $TypeCSP)
                ->andWhere('l.FlInactive = false')
                ->orderBy('l.DateCSP', 'DESC')
                ->setMaxResults($maxResults)
                ->getQuery()
                ->getResult();

            // Extraire uniquement les dates
            $dates = [];
            foreach ($results as $result) {
                $dates[] = $result->getDateCSP();
            }
            
            return $dates;
        }

        /**
         * Permet de retourner la date de CSP initiale selon la date d'arrivée du cas passé en paramètre
         *
         * @param \DateTimeInterface $dateArrivee
         * @param string $TypeCSP   - pour CM et EMM 'CSP_SIGNAL' et pour SIMAD 'CSP_SIMAD'
         * @return ListeCSP|null
         */
        public function donneDateSCPByDateArrivee(\DateTimeInterface $dateArrivee, string $TypeCSP): ?ListeCSP
        {
            $result = $this->createQueryBuilder('l')
                ->andWhere('l.TypeCSP = :val')
                ->setParameter('val', $TypeCSP)
                ->andWhere('l.FlInactive = false')
                ->andWhere('l.DateMaxArriveeMailCRPV_CEIP >= :dateArrivee')
                ->setParameter('dateArrivee', $dateArrivee)
                ->orderBy('l.DateMaxArriveeMailCRPV_CEIP', 'ASC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            return $result ?? null;
        }

    //    /**
    //     * @return ListeCSP[] Returns an array of ListeCSP objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ListeCSP
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
