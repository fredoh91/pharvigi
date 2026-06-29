<?php

namespace App\Service;

use App\Entity\CasPV;
use App\Entity\DonneesAAnonymiser;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class IAAnonymiserService
{
    public function __construct(
        private Environment $twig,
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $em,
        #[Autowire(env: 'IA_ANONYMIZER_API_KEY')] private string $apiKey,
        #[Autowire(env: 'IA_ANONYMIZER_MODEL')] private string $model,
        #[Autowire(env: 'IA_ANONYMIZER_URL')] private string $apiUrl
    ) {}

    /**
     * Analyse un texte brut via l'IA Albert et enregistre les données à anonymiser détectées.
     *
     * @param string $texteAAnonymiser Le texte brut issu du fichier Word à analyser
     * @param string $entite Le nom de l'entité cible (ex: 'FicheRecueil')
     * @param string $champ Le nom du champ de l'entité cible (ex: 'commentaire')
     * @param CasPV $casPV L'instance du dossier de pharmacovigilance lié
     */
    public function analyserTexte(string $texteAAnonymiser, string $entite, string $champ, CasPV $casPV): void
    {
        if (empty(trim($texteAAnonymiser))) {
            return;
        }

        // 1. Rendu du prompt Twig
        $prompt = $this->twig->render('ai/prompts/anonymization_check.txt.twig', [
            'text_to_analyze' => $texteAAnonymiser,
        ]);

        try {
            // 2. Appel à l'API Albert (format compatible OpenAI chat/completions)
            $response = $this->httpClient->request('POST', $this->apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'user', 
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.1, // Basse température pour éviter les hallucinations
                ],
                'timeout' => 30 // Sécurité d'exécution
            ]);

            $result = $response->toArray();
            $jsonContent = $result['choices'][0]['message']['content'] ?? '[]';

            // Nettoyage des éventuels backticks markdown introduits par l'IA (ex: ```json ... ```)
            $jsonContent = preg_replace('/^```json|```$/m', '', trim($jsonContent));
            $donneesDetectees = json_decode($jsonContent, true);

            if (!is_array($donneesDetectees)) {
                // Si l'IA a renvoyé un format JSON invalide, on coupe pour éviter un crash
                return;
            }

            // 3. Création des entrées dans la table "DonneesAAnonymiser"
            foreach ($donneesDetectees as $item) {
                // Éviter d'enregistrer des lignes vides si l'IA s'est trompée de structure
                if (empty($item['text_a_anonymiser'])) {
                    continue;
                }

                $donnee = new DonneesAAnonymiser();
                $donnee->setCasPV($casPV);
                $donnee->setEntite($entite);
                $donnee->setChamp($champ);
                $donnee->setTexteComplet($texteAAnonymiser);
                
                // Données extraites par l'IA (clés francisées)
                $donnee->setTextAAnonymiser($item['text_a_anonymiser']);
                $donnee->setCategorie($item['categorie'] ?? 'inconnu');
                $donnee->setRaison($item['raison'] ?? null);

                $this->em->persist($donnee);
            }

            // 4. On flush toutes les détections d'un coup pour ce texte
            $this->em->flush();

        } catch (\Exception $e) {
            // Ici tu peux logguer l'erreur avec le logger de Symfony si besoin
            // ex: $this->logger->error('Erreur IA Anonymiser : ' . $e->getMessage());
            throw $e; 
        }
    }
}