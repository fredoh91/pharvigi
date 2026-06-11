<?php

namespace App\Service;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\RequestStack;

class RequetesMeddraService
{
    private bool $hasError = false;

    /**
     * Symfony injecte automatiquement la connexion nommée 'meddra' 
     * définie dans config/packages/doctrine.yaml grâce à l'attribut Target.
     */
    public function __construct(
        #[Target('meddraConnection')]
        private readonly Connection $connection,
        private readonly RequestStack $requestStack
    ) {
    }

    /**
     * Indique si une erreur technique est survenue lors de la dernière requête.
     */
    public function hasError(): bool
    {
        return $this->hasError;
    }

    /**
     * Exécute une requête SQL de manière sécurisée en interceptant les exceptions.
     */
    private function executeQuerySafe(string $sql, array $params = []): ?Result
    {
        try {
            return $this->connection->executeQuery($sql, $params);
        } catch (\Exception $e) {
            $this->hasError = true;
            $this->requestStack->getSession()->getFlashBag()->add(
                'error', 
                'La base de données MEDDRA est inaccessible. Veuillez contacter l\'administrateur.'
            );
            return null;
        }
    }

    /**
     * Retourne les données effet indésirables d'un cas à partir de son masterId dans la BNPV.
     *
     * @param integer $masterId
     * @return array|null
     */
    public function DonneEIDataEn(int $codeLlt): array|null
    {
        $sql = <<<SQL
            SELECT llt.llt_name_en as LLT_Terme_En,
                h.pt_name_en as PT_Terme_En,
                hlt_name_en as HLT_Terme_En,
                hlgt_name_en as HLGT_Terme_En,
                soc_name_en as SOC_Terme_En
            FROM 1_low_level_term AS llt
            inner join 1_md_hierarchy h on h.pt_code = llt.pt_code
            WHERE llt_code = :codeLlt;
        SQL;

        $result = $this->executeQuerySafe($sql, ['codeLlt' => $codeLlt]);
        
        return $result ? $result->fetchAllAssociative() : null;
    }
}
