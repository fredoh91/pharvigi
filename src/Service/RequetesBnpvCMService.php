<?php

namespace App\Service;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\RequestStack;

class RequetesBnpvCMService
{
    private bool $hasError = false;

    /**
     * Symfony injecte automatiquement la connexion nommée 'bnpv' 
     * définie dans config/packages/doctrine.yaml grâce à l'attribut Target.
     */
    public function __construct(
        #[Target('bnpvConnection')]
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
                'La base de données BNPV est inaccessible. Veuillez contacter l\'administrateur.'
            );
            return null;
        }
    }

    /**
     * Récupère l'id de la version la plus récente d'un cas dans la BNPV.
     *
     * @param string $AER_No : numéro BNPV
     * @return integer|null
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

        $result = $this->executeQuerySafe($sql, ['AER_No' => $AER_No]);
        
        if (!$result) {
            return null;
        }

        $id = $result->fetchOne();

        return $id ? (int) $id : null;
    }


    /**
     * Retourne les données principales d'un cas à partir de son masterId dans la BNPV.
     *
     * @param integer $masterId
     * @return array|null
     */
    public function DonneMainData(int $masterId): array|null
    {
        $sql = <<<SQL
            SELECT 
            If (SUBSTR(ide.company,1,4)='CRPV', SUBSTR(mv.specificcaseid,1,2), SUBSTR(mv.specificcaseid,1,4)) as CentreAbrev,
            mv.Flag3 AS TYP_EFFET, 
            Replace(Replace(p.patientsex,'UNK','Inc'),'NASK','NS') Sexe,
            p.patientonsetage, 
            Replace(
                Replace(
                    Replace(
                        Replace(
                            Replace(
                                Replace(p.patientonsetageunitlabel,'Year','An(s)'), 
                                    'Month','Mois'),
                                    'Week','Semaine(s)'),
                                    'Day','Jour(s)'),
                                    'Hour','Heure(s)'),
                                    'Decade', 'Décennie(s)') AS UNITE_AGE,
            If (ci.iscaseserious='Yes','Oui','Non') As Gravite,
            If (INSTR(ci.seriousnesscriteria,'Death')>0,'Oui','Non') AS DC,  
            If (INSTR(ci.seriousnesscriteria,'Life Threatening')>0,'Oui','Non') AS MPV,  
            If (INSTR(ci.seriousnesscriteria,'Hospitalisation')>0,'Oui','Non') AS Hospi,  
            If (INSTR(ci.seriousnesscriteria,'Disability')>0,'Oui','Non') AS Handi,  
            If (INSTR(ci.seriousnesscriteria,'Congenital')>0,'Oui','Non') AS AnoCong, 
            If (INSTR(ci.seriousnesscriteria,'Other')>0,'Oui','Non') AS AutresGrav,  
            Trim(Replace(Replace(REPLACE(ide.company,'CRPV',''), 'CEIP',''),'SAINT-ETIENNE','SAINT-ÉTIENNE')) as Centre, 
            If (ci.medicallyconfirm='Yes','Oui','Non') As MEDICALLY_CONFIRMED
            FROM   master_versions mv
            LEFT join bi_patientinformations p ON mv.id = p.master_id
            LEFT join bi_identifiers ide ON mv.id = ide.master_id 
            LEFT JOIN  bi_caseinfo ci On mv.id = ci.master_id 
            WHERE mv.id = :masterId;
        SQL;

        $result = $this->executeQuerySafe($sql, ['masterId' => $masterId]);
        
        return $result ? $result->fetchAllAssociative() : null;
    }



    /**
     * Retourne les données effet indésirables d'un cas à partir de son masterId dans la BNPV.
     *
     * @param integer $masterId
     * @return array|null
     */
    public function DonneEIData(int $masterId): array|null
    {
        $sql = <<<SQL
            SELECT Distinct 
                r.codereactionmeddrallt as LLT_Code, 
                r.reactionmeddrallt as LLT_Terme,
                r.codereactionmeddrapt as PT_Code,
                r.reactionmeddrapt as PT_Terme,
                r.codereactionmeddrahlt as HLT_Code,
                r.reactionmeddrahlt as HLT_Terme,
                r.codereactionmeddrahlgt as HLGT_Code,
                r.reactionmeddrahlgt as HLGT_Terme,
                r.reactionmeddrasoc as SOC_Code,
                r.soc as SOC_Terme,
                r.reactionmeddraversionllt as MedDRA_Ver
            FROM bi_reaction r 
            WHERE r.master_id = :masterId 
            ORDER BY r.NBBlock;
        SQL;

        $result = $this->executeQuerySafe($sql, ['masterId' => $masterId]);
        
        return $result ? $result->fetchAllAssociative() : null;
    }

    /**
     * Retourne les antécédents médicaux d'un cas à partir de son masterId dans la BNPV.
     *
     * @param integer $masterId
     * @return string|null
     */
    public function DonneAntecedentsData(int $masterId): string|null
    {


        $sql = <<<SQL
            SELECT DISTINCT mh.patientepisodename
            FROM master_versions mv
            LEFT JOIN bi_medhistory mh ON mv.id = mh.master_id
            WHERE mv.id = :masterId;
        SQL;



        $result = $this->executeQuerySafe($sql, ['masterId' => $masterId]);
        
        if (!$result) {
            return null;
        }
        
        $rows = $result->fetchAllAssociative();
        
        // Extraire les valeurs de patientepisodename et les concaténer avec des virgules
         $values = [];
         foreach ($rows as $row) {
             if (isset($row['patientepisodename']) && $row['patientepisodename'] !== null) {
                 $values[] = $row['patientepisodename'];
             }
         }
         
         // Vérification de l'encodage des caractères
         $result = !empty($values) ? implode(', ', $values) : null;
         if ($result) {
             $result = mb_convert_encoding($result, 'UTF-8', 'Windows-1252');
         }
         
         return $result;
    }

    /**
     * Retourne les indications du/des médicament(s) d'un cas à partir de son masterId dans la BNPV.
     *
     * @param integer $masterId
     * @return string|null
     */
    public function DonneIndicationsData(int $masterId): string|null
    {


        $sql = <<<SQL
            SELECT DISTINCT id.productindication
            FROM master_versions mv
            INNER JOIN bi_product pr ON mv.id = pr.master_id
            LEFT JOIN bi_product_indication id ON pr.master_id = id.master_id AND pr.NBBlock = id.NBBlock
            WHERE pr.master_id = :masterId ; 
        SQL;
        $result = $this->executeQuerySafe($sql, ['masterId' => $masterId]);
        
        if (!$result) {
            return null;
        }
        
        $rows = $result->fetchAllAssociative();
        
        // Extraire les valeurs de productindication et les concaténer avec des virgules
        $values = [];
        foreach ($rows as $row) {
            if (isset($row['productindication']) && $row['productindication'] !== null && trim($row['productindication']) !== '') {
                $values[] = trim($row['productindication']);
            }
        }
        
        // Vérification de l'encodage des caractères
        $result = !empty($values) ? implode(', ', $values) : null;
        if ($result) {
            $result = mb_convert_encoding($result, 'UTF-8', 'Windows-1252');
        }
        
        return $result;
    }

    /**
     * Retourne les données médicament d'un cas à partir de son masterId dans la BNPV.
     *
     * @param integer $masterId
     * @return array|null
     */
    public function DonneMedicamentData(int $masterId): array|null
    {
        $sql = <<<SQL
            SELECT DISTINCT 
            pr.master_id, 
            pr.productcharacterization, 
            TRIM(REPLACE(pr.productname, '\\n', '')) productname, 
            pr.NBBlock, 
            su.substancename, 
            i.productindication, 
            su.NBBlock2 
            FROM bi_product pr 
            LEFT JOIN bi_product_substance su ON pr.master_id = su.master_id AND pr.NBBlock = su.NBBlock 
            LEFT JOIN bi_product_indication i ON pr.master_id = i.master_id  AND pr.NBBlock = i.NBBlock 
            WHERE pr.master_id = :masterId ; 
        SQL;

        $result = $this->executeQuerySafe($sql, ['masterId' => $masterId]);
        
        return $result ? $result->fetchAllAssociative() : null;
    }
}
