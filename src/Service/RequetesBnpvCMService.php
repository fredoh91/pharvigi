<?php

namespace App\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\Attribute\Target;

class RequetesBnpvCMService
{
    /**
     * Symfony injecte automatiquement la connexion nommée 'bnpv' 
     * définie dans config/packages/doctrine.yaml grâce à l'attribut Target.
     */
    public function __construct(
        #[Target('bnpvConnection')]
        private readonly Connection $connection
    ) {
    }

    /**
     * Récupère l'id de la version la plus récente d'un cas dans la BNPV.
     */
    public function DonneAerId(string $AER_No): ?int
    {
        $sql = <<<SQL
        SELECT id 
        FROM master_versions 
        WHERE specificcaseid = :AER_No
        AND id IN (
            SELECT MAX(id) 
            FROM master_versions 
            WHERE Deleted = 0 
            GROUP BY specificcaseid
        );
        SQL;

        // Utilisation de la connexion injectée pour exécuter la requête préparée
        $result = $this->connection->executeQuery($sql, ['AER_No' => $AER_No]);
        
        $id = $result->fetchOne();

        return $id ? (int) $id : null;
    }
}
