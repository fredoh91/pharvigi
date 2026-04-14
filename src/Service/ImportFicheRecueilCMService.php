<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZipArchive;
use DOMDocument;
use DOMXPath;

class ImportFicheRecueilCMService
{
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
