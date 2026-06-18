<?php

namespace App\Service;

use App\Entity\SIMAD;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZipArchive;
use DOMDocument;
use DOMXPath;

class ImportFicheRecueilSIMADService
{
    /**
     * Analyse et extrait les données structurées d'une fiche de recueil SIMAD (.docx)
     */
    public function traitementFichierWord(UploadedFile $file): array
    {
        $zip = new ZipArchive();
        if ($zip->open($file->getPathname()) !== true) {
            return ['error' => 'Impossible d\'ouvrir le fichier Word SIMAD.'];
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xml) {
            return ['error' => 'Impossible de lire le contenu XML du document Word SIMAD.'];
        }

        $dom = new DOMDocument();
        // Désactivation temporaire des erreurs pour éviter les blocages sur les namespaces spécifiques de Word
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

            // Tentative de récupération par le Tag, sinon par l'Alias
            $tagNode = $xpath->query('./w:tag/@w:val', $sdtPr)->item(0);
            $tagName = $tagNode ? $tagNode->nodeValue : null;
            
            if (!$tagName) {
                $aliasNode = $xpath->query('./w:alias/@w:val', $sdtPr)->item(0);
                $tagName = $aliasNode ? $aliasNode->nodeValue : null;
            }

            if ($tagName) {
                // 1. Détection des cases à cocher (ex: Type de substance, critères logigramme)
                $checkNode = $xpath->query('./w14:checkbox/w14:checked/@w14:val', $sdtPr)->item(0);
                if ($checkNode) {
                    $data[$tagName] = $checkNode->nodeValue === '1';
                    continue;
                }

                // 2. Détection si le champ contient un Placeholder générique de Word ("Cliquez ici pour entrer...")
                if ($xpath->query('./w:showingPlcHdr', $sdtPr)->length > 0) {
                    $data[$tagName] = '';
                    continue;
                }

                // 3. Extraction textuelle stricte du contenu
                $contentNode = $xpath->query('./w:sdtContent', $node)->item(0);
                $value = $contentNode ? $this->extractTextStrict($contentNode) : '';
                
                // Nettoyage des espaces insécables et tabulations
                $value = str_replace(["\t", "\xc2\xa0"], " ", $value);
                $value = preg_replace('/ +/', ' ', $value); 
                $value = trim($value);
                
                // Gestion de la concaténation si un même tag est présent à plusieurs reprises
                if (isset($data[$tagName]) && $data[$tagName] !== $value && $value !== '') {
                    $data[$tagName] .= "\n" . $value;
                } elseif (!isset($data[$tagName])) {
                    $data[$tagName] = $value;
                }
            }
        }

        // --- FALLBACK : Si aucune donnée structurée n'a été extraite via SDT ---
        if (empty($data)) {
            $textRaw = strip_tags($xml);
            
            // Normalisation du texte brut pour faciliter l'extraction par regex
            $textRaw = str_replace(["\xc2\xa0", "\t", "\n", "\r"], " ", $textRaw);
            $textRaw = preg_replace('/\s+/', ' ', $textRaw);

            // Extraction des champs de base
            $patterns = [
                'Num_Cas'            => '/Numéro BNPV\s*:\s*(.*?)(?=Date de l’évènement|$)/iu',
                'Date_evenement'     => '/Date de l’évènement\s*:\s*(.*?)(?=Date de la notification|$)/iu',
                'Date_notification'  => '/Date de la notification\s*:\s*(.*?)(?=\* Nom de la \(des\) substance\(s\)|$)/iu',
                'Nom_scientifique'   => '/Nom scientifique\s*:\s*(.*?)(?=nom d’usage|$)/iu',
                'Nom_usage'          => '/nom d’usage\s*:\s*(.*?)(?=Pour substance non médicamenteuse|$)/iu',
                'Effets_observes'    => '/\* Effet\(s\) observé\(s\)\s*(.*?)(?=Lettre du logigramme|$)/isu',
                'Lettre_logigramme'  => '/Lettre du logigramme\s*:\s*(.*?)(?=\* Problématique|$)/iu',
            ];

            foreach ($patterns as $key => $pattern) {
                if (preg_match($pattern, $textRaw, $matches)) {
                    $data[$key] = trim($matches[1]);
                }
            }

            // Checkboxes pour 'Médicament(s)' et 'Substance(s) non médicamenteuse(s)'
            $data['Substance_Medicament'] = (stripos($textRaw, '☒ Médicament (s)') !== false);
            $data['Substance_Non_Medicament'] = (stripos($textRaw, '☒ Substance(s) non médicamenteuse(s)') !== false);

            // Types de substance (checkboxes)
            $typeSubstanceBlock = '';
            if (preg_match('/Pour substance non médicamenteuse, précisez le type de Substance\s*:\s*.*?((?:☐|☒).*?)(?=S’agit-il d’une nouvelle substance|$)/siu', $textRaw, $matches)) {
                $typeSubstanceBlock = $matches[1];
            }
            $data['TypeSubstance_Amphetamines'] = (stripos($typeSubstanceBlock, '☒ Amphétamines-Ecstasy/MDMA') !== false);
            $data['TypeSubstance_Cannabis'] = (stripos($typeSubstanceBlock, '☒ Cannabis/Cannabinoïdes') !== false);
            $data['TypeSubstance_Cathinones'] = (stripos($typeSubstanceBlock, '☒ Cathinones') !== false);
            $data['TypeSubstance_Cocaine'] = (stripos($typeSubstanceBlock, '☒ Cocaïne/Crack') !== false);
            $data['TypeSubstance_Benzodiazepines'] = (stripos($typeSubstanceBlock, '☒ Designer benzodiazépines') !== false);
            $data['TypeSubstance_LSD'] = (stripos($typeSubstanceBlock, '☒ LSD et dérivés') !== false);
            $data['TypeSubstance_Opioides'] = (stripos($typeSubstanceBlock, '☒ Opioïdes') !== false);
            $data['TypeSubstance_Phenidates'] = (stripos($typeSubstanceBlock, '☒ Phénidates') !== false);
            $data['TypeSubstance_PlantesChampignons'] = (stripos($typeSubstanceBlock, '☒ Plantes/Champignons') !== false);
            $data['TypeSubstance_Volatiles'] = (stripos($typeSubstanceBlock, '☒ Substances volatiles') !== false);
            
            if (preg_match('/☒ Autre type de substance \(préciser\)\s*:\s*(.*?)(?=S’agit-il d’une nouvelle substance|$)/siu', $typeSubstanceBlock, $matches)) {
                $data['TypeSubstance_Autre'] = trim($matches[1]);
            } else {
                $data['TypeSubstance_Autre'] = false;
            }

            // Nouvelle substance / nouvelle association
            $nouvelleSubstanceBlock = '';
            if (preg_match('/S’agit-il d’une nouvelle substance ou nouvelle association de substances sur le territoire national \? Si oui, justifier \? (.*?)(?=\* Effet\(s\) observé\(s\)|$)/siu', $textRaw, $matches)) {
                $nouvelleSubstanceBlock = $matches[1];
            }
            $data['NouvelleSubstance_Checked'] = (stripos($nouvelleSubstanceBlock, '☒') !== false);
            $data['NouvelleSubstance_Justification'] = trim(str_ireplace('Cliquez ici pour entrer du texte.', '', $nouvelleSubstanceBlock));
            
            // Problématique / Raisons de la qualification (checkbox)
            $data['Probl_TableauCliniqueNouveau'] = (stripos($textRaw, '☒ Tableau clinique nouveau/« inattendu » et/ou sévère/grave') !== false);
        }

        return [
            'Data_FicheRecueilSIMAD' => $data
        ];
    }

    /**
     * Crée et hydrate l'objet entité métier dédié à l'Addictovigilance (ex: CasAddicto ou CasPV)
     */
    public function CreationCasSIMAD(
        array $ficRec, 
        array $mainData, 
        array $substanceDataRows, 
        RequetesMeddraService $requetesMeddraService
    ): SIMAD {

        $simad = new SIMAD();

        // Hydration from extracted Word data ($ficRec)
        $simad->setNumeroBNPV($ficRec['Num_Cas'] ?? null);
        $simad->setDateEvenement($ficRec['Date_EI'] ?? null);
        $simad->setDateNotification($ficRec['Date_Not'] ?? null);
        
        // Inherited CasPV fields
        $simad->setTypeCasPV('SIMAD');
        if (isset($ficRec['Probl_TableauCliniqueNouveau']) && $ficRec['Probl_TableauCliniqueNouveau'] === true) {
            $simad->setProblematique($ficRec['Tb_Clin_Nv_Txt'] ?? 'Tableau clinique nouveau/« inattendu » et/ou sévère/grave');
        } else {
            $simad->setProblematique(null);
        }

        // Fields from mainData (BNPV) - assuming structure similar to CM/EMM
        if (!empty($mainData)) {
            if (isset($mainData['AGE_YEARS'])) {
                $simad->setAge((int)$mainData['AGE_YEARS']);
                $simad->setUniteAge('ans');
            }
            if (isset($mainData['GENDER_CODE'])) {
                $simad->setSexe($mainData['GENDER_CODE']);
            }
            // Other mappings from mainData if applicable
        }
        
        // Handle specific SIMAD fields (substances, etc.)
        // This is a simplified mapping; actual mapping would depend on your SIMAD entity
        // For example, you might have related entities for substances.
        $presentationText = '';
        if (isset($ficRec['Substance_Medicament']) && $ficRec['Substance_Medicament'] === true) {
            $presentationText .= 'Médicament: ';
        } elseif (isset($ficRec['Substance_Non_Medicament']) && $ficRec['Substance_Non_Medicament'] === true) {
            $presentationText .= 'Substance non médicamenteuse: ';
        }
        $presentationText .= ($ficRec['Nom_Scient'] ?? '') . ' / ' . ($ficRec['Nom_Usage'] ?? '');
        $simad->setPresentation($presentationText);

        $simad->setEffetIndesirable($ficRec['EIs'] ?? null);
        $simad->setLettre($ficRec['Lettre_Logi'] ?? null);
        
        return $simad; // Retourner l'entité construite non persistée
    }

    /**
     * Extraction récursive du texte à l'intérieur des balises Word OpenXML
     */
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