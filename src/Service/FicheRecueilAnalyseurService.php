<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZipArchive;

class FicheRecueilAnalyseurService
{
    public const TYPE_CM = 'CM';
    public const TYPE_EMM = 'EMM';
    public const TYPE_SIMAD = 'SIMAD';
    public const TYPE_UNKNOWN = 'UNKNOWN';

    /**
     * Analyse globale du fichier pour déterminer le type et valider le format de base
     */
    public function analyserFichier(UploadedFile $file): array
    {
        $rawText = $this->extractRawTextFromWord($file);
        
        if (empty($rawText)) {
            return [
                'valide' => false,
                'type' => self::TYPE_UNKNOWN,
                'error' => 'Le fichier est vide ou n\'est pas un document Word (.docx) valide.'
            ];
        }

        // 1. Détection du type de document par mots-clés spécifiques
        $type = self::TYPE_UNKNOWN;
        
        if (stripos($rawText, 'ADDICTOVIGILANCE') !== false || stripos($rawText, 'SIMAD') !== false) {
            // Confirmé par vos fichiers : la présence de SIMAD ou ADDICTOVIGILANCE signe le document
            $type = self::TYPE_SIMAD;
        } elseif (stripos($rawText, 'CAS MARQUANTS') !== false || stripos($rawText, 'Vigylise') !== false) {
            $type = self::TYPE_CM;
        } elseif (stripos($rawText, 'ERREURS MEDICAMENTEUSES') !== false || stripos($rawText, 'Erreur Avérée') !== false || stripos($rawText, 'Logigramme') !== false) {
            $type = self::TYPE_EMM;
        }

        if ($type === self::TYPE_UNKNOWN) {
            return [
                'valide' => false,
                'type' => self::TYPE_UNKNOWN,
                'error' => 'Type de document inconnu (Le fichier ne semble pas être une fiche CM, EMM ou SIMAD).'
            ];
        }

        // 2. Recherche et validation du numéro BNPV (Ajusté pour inclure Pharmacovigilance et Addictovigilance)
        $numCas = null;
        
        // Expression régulière mise à jour :
        // Option A : Format Addictovigilance (ex: AVNT26000033 ou AVPA2025000032) -> AV + 2 lettres + 8 à 10 chiffres
        // Option B : Format Pharmacovigilance standard (ex: MP2026000620, NC2026000728) -> 2 lettres + 10 chiffres
        if (preg_match('/(AV[A-Z]{2}\d{8,10})|([A-Z]{2}\d{10})/i', $rawText, $matches)) {
            $numCas = strtoupper($matches[0]);
        } elseif (preg_match('/[A-Z]\d{2}-\d+/i', $rawText, $matches)) {
            $numCas = strtoupper($matches[0]); // Sécurité pour les formats locaux type N26-1091
        }

        return [
            'valide' => true,
            'type' => $type,
            'num_cas' => $numCas,
            'text_raw' => $rawText
        ];
    }

    /**
     * Extraction rapide du texte brut d'un document .docx (fichiers OpenXML)
     */
    private function extractRawTextFromWord(UploadedFile $file): string
    {
        $zip = new ZipArchive();
        if ($zip->open($file->getPathname()) !== true) {
            return '';
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xml) {
            return '';
        }

        return strip_tags($xml);
    }
}