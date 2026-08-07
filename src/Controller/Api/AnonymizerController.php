<?php

namespace App\Controller\Api;

use App\Entity\DonneesAAnonymiser;
use App\Repository\DonneesAAnonymiserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnonymizerController extends AbstractController
{
    #[Route('/api/anonymizer/{entite}/{champ}/{casPvId}', name: 'api_anonymizer_get_strings', methods: ['GET'])]
    public function getAnonymizedStrings(
        string $entite, 
        string $champ, 
        int $casPvId,
        DonneesAAnonymiserRepository $repository
    ): JsonResponse {
        try {
            // Récupérer les données d'anonymisation pour cet entité, champ et casPV
            $anonymizationData = $repository->findBy([
                'entite' => $entite,
                'champ' => $champ,
                'CasPV' => $casPvId
            ], [], 100); // Limite à 100 résultats
            
            // Préparer les données pour le frontend
            $resultData = [];
            foreach ($anonymizationData as $data) {
                $resultData[] = [
                    'id' => $data->getId(),
                    'textAAnonymiser' => $data->getTextAAnonymiser(),
                    'texteComplet' => $data->getTexteComplet(),
                    'categorie' => $data->getCategorie(),
                    'raison' => $data->getRaison()
                ];
            }
            
            return $this->json([
                'success' => true,
                'data' => $resultData
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
