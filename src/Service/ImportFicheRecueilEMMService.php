<?php

namespace App\Service;

use App\Entity\EMM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZipArchive;
use DOMDocument;
use DOMXPath;

class ImportFicheRecueilEMMService
{
    public function traitementFichierWord(UploadedFile $file): array
    {
        $zip = new ZipArchive();
        if ($zip->open($file->getPathname()) !== true) {
            return ['error' => 'Impossible d\'ouvrir le fichier Word EMM.'];
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xml) {
            return ['error' => 'Impossible de lire le contenu du document Word EMM.'];
        }

        $dom = new DOMDocument();
        // Libération des erreurs si le XML comporte des entités Word spécifiques mal définies
        libxml_use_internal_errors(true);
        $dom->loadXML($xml);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $xpath->registerNamespace('w14', 'http://schemas.microsoft.com/office/word/2010/wordml');

        $data = [];
        $sdtNodes = $xpath->query('//w:sdt');
        
        foreach ($sdtNodes as $node) {
            $sdtPr = $xpath->query('./w:sdtPr', $node)->item(0);
            if (!$sdtPr) continue;

            $tagNode = $xpath->query('./w:tag/@w:val', $sdtPr)->item(0);
            $tagName = $tagNode ? $tagNode->nodeValue : null;
            
            if (!$tagName) {
                $aliasNode = $xpath->query('./w:alias/@w:val', $sdtPr)->item(0);
                $tagName = $aliasNode ? $aliasNode->nodeValue : null;
            }

            if ($tagName) {
                $isPlaceholder = $xpath->query('./w:showingPlcHdr', $sdtPr)->length > 0;
                
                // Gestion des cases à cocher natales de Word 2010+
                $checkNode = $xpath->query('./w14:checkbox/w14:checked/@w14:val', $sdtPr)->item(0);
                if ($checkNode) {
                    $data[$tagName] = $checkNode->nodeValue === '1';
                    continue;
                }

                if ($isPlaceholder) {
                    $data[$tagName] = '';
                    continue;
                }

                // Extraction textuelle stricte
                $contentNode = $xpath->query('./w:sdtContent', $node)->item(0);
                $value = $contentNode ? $this->extractTextStrict($contentNode) : '';
                
                $value = str_replace(["\t", "\xc2\xa0"], " ", $value);
                $value = preg_replace('/ +/', ' ', $value); 
                $value = trim($value);
                
                if (isset($data[$tagName]) && $data[$tagName] !== $value && $value !== '') {
                    $data[$tagName] .= "\n" . $value;
                } elseif (!isset($data[$tagName])) {
                    $data[$tagName] = $value;
                }
            }
        }

        // --- FALLBACK : Si aucune donnée structurée n'a été extraite via SDT (ex: template Word sans balises w:tag) ---
        if (empty($data)) {
            $textRaw = strip_tags($xml);
            
            // Normalisation du texte brut pour faciliter l'extraction par regex
            $textRaw = str_replace(["\xc2\xa0", "\t", "\n", "\r"], " ", $textRaw);
            $textRaw = preg_replace('/\s+/', ' ', $textRaw);

            $patterns = [
                'Num_Cas'    => '/Numéro BNPV\s*:\s*(?:FORMTEXT\s*)?([A-Z0-9-]+)/iu',
                'Sexe'       => '/Sexe\s*:\s*([MF])/iu',
                'Age'        => '/Age\s*:\s*(?:FORMTEXT\s*)?(\d+)/iu',
                'Specialite' => '/Spécialité\(s\)\s*–?DCI\s*–?\s*présentation\s*:\s*(?:FORMTEXT\s*)?(.*?)(?=Indication\s*:|$)/isu',
                'Indication' => '/Indication\s*:\s*(?:FORMTEXT\s*)?(.*?)(?=Erreur médicamenteuse\s*:|$)/isu',
                'Resume'     => '/Résumé synthétique .*?:\s*(?:FORMTEXT\s*)?(.*)$/isu',
            ];

            foreach ($patterns as $key => $pattern) {
                if (preg_match($pattern, $textRaw, $matches)) {
                    $data[$key] = trim($matches[1]);
                }
            }

            // Extraction rudimentaire des cases à cocher via regex sur le texte brut pour le template legacy
            // Notificateur
            if (preg_match('/Notificateur\s*:\s*(?:☒PS\s*)?(?:☐Patient\s*)?(?:☐cellule qualité\s*)?(?:☐cellule gestion des risques\s*)?(?:☐Autre\s*:\s*(?:FORMTEXT\s*)?(.*?))?/iu', $textRaw, $matches)) {
                $data['Notificateur_PS'] = (stripos($matches[0], '☒PS') !== false);
                $data['Notificateur_Patient'] = (stripos($matches[0], '☐Patient') === false && stripos($matches[0], '☒Patient') !== false); // Check for ☒Patient
                $data['Notificateur_CelluleQualite'] = (stripos($matches[0], '☐cellule qualité') === false && stripos($matches[0], '☒cellule qualité') !== false);
                $data['Notificateur_CelluleGestionRisques'] = (stripos($matches[0], '☐cellule gestion des risques') === false && stripos($matches[0], '☒cellule gestion des risques') !== false);
                $data['Notificateur_Autre'] = isset($matches[1]) && trim($matches[1]) !== '' ? trim($matches[1]) : (stripos($matches[0], '☒Autre') !== false ? true : false);
            }

            // Erreur médicamenteuse
            if (preg_match('/Erreur médicamenteuse\s*:\s*(?:☒ Erreur Avérée\s*)?(?:☐ Erreur potentielle\s*)?(?:☐ Risque d’erreur médicamenteuse)?/iu', $textRaw, $matches)) {
                $data['EM_Avere'] = (stripos($matches[0], '☒ Erreur Avérée') !== false);
                $data['EM_Potentiel'] = (stripos($matches[0], '☒ Erreur potentielle') !== false);
                $data['EM_Risque'] = (stripos($matches[0], '☒ Risque d’erreur médicamenteuse') !== false);
            }

            // Etape initiale de l’erreur
            if (preg_match('/Etape initiale de l’erreur\s*:\s*(?:☐ Prescription\s*)?(?:☐ Délivrance\s*)?(?:☒ Administration\s*)?(?:☐ Préparation\s*)?(?:☐ NA \(Risque d’erreur\))?/iu', $textRaw, $matches)) {
                $data['Step_Presc'] = (stripos($matches[0], '☒ Prescription') !== false);
                $data['Step_Deliv'] = (stripos($matches[0], '☒ Délivrance') !== false);
                $data['Step_Admin'] = (stripos($matches[0], '☒ Administration') !== false);
                $data['Step_Prep'] = (stripos($matches[0], '☒ Préparation') !== false);
                $data['Step_NA'] = (stripos($matches[0], '☒ NA (Risque d’erreur)') !== false);
            }

            // Cause(s) de l’EM
            if (preg_match('/Cause\(s\) de l’EM\s*:\s*.*?((?:☐|☒)\s*Similitude des dénominations commerciales\/communes.*?)(?=(?:Conséquences de l’EM|$))/siu', $textRaw, $matches)) {
                $causeText = $matches[1];
                $data['Cause_SimilitudeDenominations'] = (stripos($causeText, '☒ Similitude des dénominations commerciales/communes') !== false);
                $data['Cause_SimilitudeComprimes'] = (stripos($causeText, '☒ Similitude des comprimés/gélules') !== false);
                $data['Cause_SimilitudeConditionnementsPrimaires'] = (stripos($causeText, '☒ Similitude des conditionnements primaires') !== false);
                $data['Cause_SimilitudeConditionnementsExterieurs'] = (stripos($causeText, '☒ Similitude des conditionnements extérieurs (boites)') !== false);
                $data['Cause_ManqueLisibilite'] = (stripos($causeText, '☒ Manque de lisibilité des mentions de l’étiquetage') !== false);
                $data['Cause_InformationManquante'] = (stripos($causeText, '☒ Information manquante ou confuse dans la notice, RCP, étiquetage') !== false);
                $data['Cause_PresentationInadaptee'] = (stripos($causeText, '☒ Présentation inadaptée') !== false);
                
                if (preg_match('/☒ Autres, préciser\s*:\s*(?:FORMTEXT\s*)?(.*?)(?=(?:☐|☒|Conséquences de l’EM|$))/siu', $causeText, $otherMatches)) {
                    $data['Cause_Autres'] = trim($otherMatches[1]);
                } else {
                    $data['Cause_Autres'] = false;
                }
            }


            // Conséquences de l’EM
            if (preg_match('/Conséquences de l’EM\s*:\s*(.*?)(?:[*]+)/siu', $textRaw, $matches)) {
                $consequenceText = $matches[1];
                $data['Consequence_GravesAveres'] = (stripos($consequenceText, '☒ l’EM a conduit à un/des EI considéré(s) comme grave(s)') !== false);
                $data['Consequence_GravesPotentielles'] = (stripos($consequenceText, '☒ l’EM aurait pu conduire à un ou des EI/conséquences grave(s)') !== false);
            }

            // Niveau (Niveau 1, Niveau 2) - now correctly delimited by asterisks
            if (preg_match('/\*+\s*(.*?)(?=\s*\*+\s*Chiffre du logigramme)/siu', $textRaw, $niveauMatches)) {
                $niveauBlock = $niveauMatches[1];
                $data['Niveau_1'] = (stripos($niveauBlock, '☒ Niveau 1') !== false);
                $data['Niveau_2'] = (stripos($niveauBlock, '☒ Niveau 2') !== false);
            }

            // Chiffre du logigramme
            if (preg_match('/Chiffre du logigramme\s*:\s*(?:☐ Cas\s*6\s*)?(?:☒ Cas\s*7\s*)?/iu', $textRaw, $matches)) {
                $data['Logigramme_Cas6'] = (stripos($matches[0], '☒ Cas 6') !== false);
                $data['Logigramme_Cas7'] = (stripos($matches[0], '☒ Cas 7') !== false);
            }

            // Critères pour l’analyse de risque
            if (preg_match('/Critères pour l’analyse de risque\s*:\s*cocher un ou plusieurs critères\s*:\s*(.*?)(?=(?:Résumé synthétique|$))/siu', $textRaw, $matches)) {
                $riskCriteriaText = $matches[1]; // The block of text containing the checkboxes
                $data['Critere_ProblematiqueRecurrente'] = (stripos($riskCriteriaText, '☒ Problématique récurrente / persistante') !== false);
                $data['Critere_Cluster'] = (stripos($riskCriteriaText, '☒ Cluster (≥2)') !== false);
                $data['Critere_EMenfant'] = (stripos($riskCriteriaText, '☒ EM survenue chez un enfant') !== false);
                $data['Critere_UsageParticulier'] = (stripos($riskCriteriaText, '☒ Usage particulier') !== false);
                $data['Critere_ContexteMediatique'] = (stripos($riskCriteriaText, '☒ Contexte médiatique, judicaire') !== false);
            }
        }

        // Mapping de sécurité pour le numéro de cas
        if (isset($data['Numero_BNPV']) && !isset($data['Num_Cas'])) {
            $data['Num_Cas'] = $data['Numero_BNPV'];
        } elseif (isset($data['Num_Cas']) && !isset($data['Numero_BNPV'])) {
            $data['Numero_BNPV'] = $data['Num_Cas'];
        }

        return [
            'Data_FicheRecueilEMM' => $data
        ];
    }

    /**
     * Crée l'objet entité métier EMM pré-rempli à partir des données extraites et de la BNPV
     */
    public function CreationCasEMM(array $ficRec, array $mainData, array $eiDataRows, array $medicDataRows, RequetesMeddraService $requetesMeddraService): EMM
    {
        $emm = new EMM();
        
        // 1. Données issues de l'extraction Word
        $emm->setNumeroBNPV($ficRec['Num_Cas'] ?? null);
        $emm->setSexe($ficRec['Sexe'] ?? null);
        $emm->setAge(isset($ficRec['Age']) ? (int)$ficRec['Age'] : null);
        $emm->setProblematique($ficRec['Resume'] ?? null);
        $emm->setCluster($ficRec['Cluster'] ?? false);
        $emm->setTypeCasPV('EMM');

        // 2. Données issues de la BNPV (prioritaires si disponibles)
        if (!empty($mainData)) {
            if (isset($mainData['AGE_YEARS'])) {
                $emm->setAge((int)$mainData['AGE_YEARS']);
                $emm->setUniteAge('ans');
            }
            if (isset($mainData['GENDER_CODE'])) {
                $emm->setSexe($mainData['GENDER_CODE']);
            }
            // Autres mappings possibles selon votre structure BNPV
        }

        return $emm;
    }

    private function extractTextStrict(\DOMNode $node): string
    {
        $text = '';
        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'w:sdt') continue;
            
            if ($child->nodeName === 'w:t') {
                $text .= $child->nodeValue;
            } elseif ($child->nodeName === 'w:br' || $child->nodeName === 'w:cr') {
                $text .= "\n";
            } elseif ($child->nodeName === 'w:p') {
                $subText = trim($this->extractTextStrict($child));
                if ($subText !== '') {
                    $text .= $subText . "\n";
                }
            } else {
                $text .= $this->extractTextStrict($child);
            }
        }
        return $text;
    }
}
