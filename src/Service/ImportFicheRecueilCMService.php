<?php

namespace App\Service;

use App\Entity\CM\CM;
use App\Entity\CM\DonneesComplementairesCM;
use App\Entity\StatutCasPV;
// use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use DOMXPath;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ZipArchive;

class ImportFicheRecueilCMService
{
    private Security $security;
    private EntityManagerInterface $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }
    public function TraitementFichierWord(UploadedFile $file): array
    {
        $zip = new ZipArchive();
        if ($zip->open($file->getPathname()) !== true) {
            return ['error' => 'Impossible d\'ouvrir le fichier Word.'];
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xml) {
            return ['error' => 'Impossible de lire le contenu du document Word.'];
        }

        $dom = new DOMDocument();
        $dom->loadXML($xml);
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
                // 1. Détection du placeholder : si w:showingPlcHdr est présent, le champ est considéré comme vide
                $isPlaceholder = $xpath->query('./w:showingPlcHdr', $sdtPr)->length > 0;
                
                // 2. Gestion des checkboxes
                $checkNode = $xpath->query('./w14:checkbox/w14:checked/@w14:val', $sdtPr)->item(0);
                if ($checkNode) {
                    // $data[$tagName] = $checkNode->nodeValue === '1' ? '☒' : '☐';
                    // Retourne un booléen: true si coché, false sinon
                    $data[$tagName] = $checkNode->nodeValue === '1';
                    continue;
                }

                if ($isPlaceholder) {
                    $data[$tagName] = '';
                    continue;
                }

                // 3. Extraction et nettoyage du texte
                $contentNode = $xpath->query('./w:sdtContent', $node)->item(0);
                $value = '';
                if ($contentNode) {
                    $value = $this->extractTextStrict($contentNode);
                }
                
                // Nettoyage final : suppression des \t, normalisation des espaces
                $value = str_replace(["\t", "\xc2\xa0"], " ", $value);
                $value = preg_replace('/ +/', ' ', $value); // Multiples espaces -> un seul
                $value = trim($value);
                
                // Gestion des doublons de tags (concaténation avec saut de ligne si différent)
                if (isset($data[$tagName]) && $data[$tagName] !== $value && $value !== '') {
                    $data[$tagName] .= "\n" . $value;
                } elseif (!isset($data[$tagName])) {
                    $data[$tagName] = $value;
                }
            }
        }

        return [
            'Data_FicheRecueilCM' => $data
        ];
    }

    /**
     * Création d'un objet CM (CasPV JTI CM) et hydratation avec les données extraites de la fiche de recueil et de la BNPV
     *
     * @param array $ficRec : Données extraites de la fiche de recueil CM
     * @param array $mainData : Données principales issues de la BNPV
     * @param array $eiDataRows : Données des événements indésirables issus de la BNPV
     * @param array $medicDataRows : Données des médicaments issus de la BNPV
     * @param RequetesMeddraService $requetesMeddraService
     * @return CM
     */
    public function CreationCasCM(array $ficRec, array $mainData, array $eiDataRows, array $medicDataRows, RequetesMeddraService $requetesMeddraService): CM
    {
        
        $user = $this->security->getUser();
        if (!$user) {
            throw new AccessDeniedException('Utilisateur non connecté.');
        }
        if (method_exists($user, 'getUserIdentifier')) {
            $userName = $user->getUserIdentifier();
        } elseif (method_exists($user, 'getUserName')) {
            $userName = $user->getUserName();
        } elseif (method_exists($user, 'getUsername')) {
            $userName = $user->getUsername();
        } else {
            $userName = (string) $user;
        }
        $now = new \DateTimeImmutable();

        $cm = new CM();
        
        dump($ficRec, $mainData, $eiDataRows, $medicDataRows);
        // 1. Données issues de l'extraction Word
        $cm->setTypeCasPV('CM');
        // $cm->setTypologie('Effet indésirable');
        $cm->setNumeroBNPV($ficRec['Num_Cas'] ?? null);
        
        $cm->setEffetIndesirable($ficRec['EIs'] ?? null);
        $cm->setLettre($ficRec['LettreLogi'] ?? null);
        
        $cm->setProblematique($ficRec['Resume'] ?? null);
        $cm->setCluster($ficRec['Cluster'] ?? false);
        
        $cm->setCreatedAt($now);
        $cm->setUpdatedAt($now);
        $cm->setUserCreate($userName);
        $cm->setUserModif($userName);
        
        $statutCas = new StatutCasPV();

        $statutCas->setStatutActif(true);
        $statutCas->setLibStatut('brouillon');
        $statutCas->setDateMiseEnPlace(new \DateTimeImmutable());
        $statutCas->setCreatedAt($now);
        $statutCas->setUpdatedAt($now);
        $statutCas->setUserCreate($userName);
        $statutCas->setUserModif($userName);        
        
        $cm->addStatutCasPV($statutCas);

        // 2. Données issues de la BNPV
        if (!empty($mainData)) {
            $cm->setSexe($mainData['Sexe'] ?? null);
            $cm->setAge(isset($mainData['patientonsetage']) ? (int)$mainData['patientonsetage'] : null);
            $cm->setUniteAge($mainData['UNITE_AGE'] ?? null);
            $cm->setGravite($mainData['Gravite'] ?? null);
            $cm->setDeces($mainData['DC'] ?? null);
            $cm->setMiseEnJeuPronostic($mainData['MPV'] ?? null);
            $cm->setHospitalisation($mainData['Hospi'] ?? null);
            $cm->setIncapacite($mainData['Handi'] ?? null);
            $cm->setAnomalieCongenitale($mainData['AnoCong'] ?? null);
            $cm->setAutreSituation($mainData['AutresGrav'] ?? null);
            // if (isset($mainData['AGE_YEARS'])) {
            //     $cm->setAge((int)$mainData['AGE_YEARS']);
            //     $cm->setUniteAge('ans');
            // }
            // if (isset($mainData['GENDER_CODE'])) {
            //     $cm->setSexe($mainData['GENDER_CODE']);
            // }
            // Autres mappings possibles selon votre structure BNPV
        }
        $this->em->persist($cm);
        $this->em->persist($statutCas);
        $this->em->flush();
        return $cm;
    }
/**
     * Création d'un objet CM (CasPV JTI CM) et hydratation avec les données extraites de la fiche de recueil et de la BNPV
     *
     * @param array $ficRec : Données extraites de la fiche de recueil CM
     * @param array $mainData : Données principales issues de la BNPV
     * @param array $eiDataRows : Données des événements indésirables issus de la BNPV
     * @param array $medicDataRows : Données des médicaments issus de la BNPV
     * @param CM $cm
     * @return DonneesComplementairesCM
     */
    public function CreationDonneesComplementairesCM(array $ficRec, array $mainData, array $eiDataRows, array $medicDataRows, CM $cm): DonneesComplementairesCM
    {
        
        $user = $this->security->getUser();
        if (!$user) {
            throw new AccessDeniedException('Utilisateur non connecté.');
        }
        if (method_exists($user, 'getUserIdentifier')) {
            $userName = $user->getUserIdentifier();
        } elseif (method_exists($user, 'getUserName')) {
            $userName = $user->getUserName();
        } elseif (method_exists($user, 'getUsername')) {
            $userName = $user->getUsername();
        } else {
            $userName = (string) $user;
        }
        $now = new \DateTimeImmutable();

        $donComplCM = new DonneesComplementairesCM();

        $donComplCM->setCm($cm);
        // $donComplCM->setCreatedAt($now);
        // $donComplCM->setUpdatedAt($now);
        // $donComplCM->setUserCreate($userName);
        // $donComplCM->setUserModif($userName);
        $donComplCM->setEIAttendu($ficRec['EI_Attendu'] ?? null);
        $donComplCM->setEIInattendu($ficRec['EI_Inattendu'] ?? null);
        $donComplCM->setPlausibilitePharma($ficRec['Plausib_Pharma'] ?? null);
        $donComplCM->setTabCliniInhab($ficRec['Tab_Clinique_Inhab'] ?? null);
        $donComplCM->setTabCliniInhabComment($ficRec['Tab_Clin_Inhab_Txt'] ?? null);
        $donComplCM->setChronoEvo($ficRec['Chrono_Evoc'] ?? null);
        $donComplCM->setSemioEvo($ficRec['Semio_Evoc'] ?? null);
        $donComplCM->setSemioEvoComment($ficRec['Semio_Evoc_Txt'] ?? null);
        
        $donComplCM->setContexPriseMedic($ficRec['Context_Part'] ?? null);
        $donComplCM->setContexPriseMedicComment($ficRec['Context_Part_Txt'] ?? null);
        $this->em->persist($donComplCM);
        $this->em->flush();
        return $donComplCM;
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
