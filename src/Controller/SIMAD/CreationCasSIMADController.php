<?php

namespace App\Controller\SIMAD;

use App\Form\SIMAD\UploadFicheRecueilSIMADType;
use App\Service\FicheRecueilAnalyseurService;
use App\Service\ImportFicheRecueilSIMADService;
use App\Service\RequetesBnpvCMService;
use App\Service\RequetesMeddraService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class CreationCasSIMADController extends AbstractController
{
    #[Route('/creation_cas', name: 'app_simad_creation_cas')]
    public function uploadFicheRecueilSIMAD(
        Request $request, 
        FicheRecueilAnalyseurService $analyseurService,
        ImportFicheRecueilSIMADService $importSIMADService, 
        RequetesBnpvCMService $requetesBnpvService, 
        RequetesMeddraService $requetesMeddraService, 
        ManagerRegistry $doctrine,
        EntityManagerInterface $em, 
        AuthenticationUtils $authenticationUtils
        ): Response
    {
        $form = $this->createForm(UploadFicheRecueilSIMADType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $FicWordRecueilSIMAD = $form->get('FicWordRecueilSIMAD')->getData();
            
            if ($FicWordRecueilSIMAD) {
                
                // --- ÉTAPE 1 : PRÉ-ANALYSE DU FICHIER ---
                $analyseResult = $analyseurService->analyserFichier($FicWordRecueilSIMAD);

                if (!$analyseResult['valide']) {
                    $this->addFlash('error', $analyseResult['error']);
                    return $this->redirectToRoute('app_simad_creation_cas');
                }

                $typeFiche = $analyseResult['type'];

                // --- ÉTAPE 2 : AIGUILLAGE & SÉCURITÉ CONTEXTUELLE ---
                // Le contrôleur est dédié aux fiches SIMAD, donc cette vérification n'est plus nécessaire ici.
                // Le type de fiche est déjà confirmé par $analyseResult['type'] === FicheRecueilAnalyseurService::TYPE_SIMAD.

                dump($typeFiche);

                $ficRec = [];

                // Le type de fiche est déjà SIMAD à ce point, donc on peut directement appeler le service SIMAD
                $result = $importSIMADService->TraitementFichierWord($FicWordRecueilSIMAD);
                if (isset($result['error'])) {
                    $this->addFlash('error', $result['error']);
                    return $this->redirectToRoute('app_simad_creation_cas');
                }
                $ficRec = $result['Data_FicheRecueilSIMAD'] ?? null;

                dump($ficRec);

                // --- ÉTAPE 3 : VALIDATION DES DONNÉES EXTRAITES ---
                if (!$ficRec) {
                    $this->addFlash('error', 'Aucun champ n\'a pu être extrait du document Word.');
                    return $this->redirectToRoute('app_simad_creation_cas');
                }

                $numCas = $ficRec['Num_Cas'] ?? $analyseResult['num_cas'];

                if (empty($numCas)) {
                    $this->addFlash('error', 'Numéro de cas absent ou illisible dans le document Word.');
                    return $this->redirectToRoute('app_simad_creation_cas');
                }

                $NumBNPV = trim($numCas);
                
                if (strlen($NumBNPV) > 14) {
                    $this->addFlash('error', 'Le numéro du cas ne doit pas comprendre plus de 14 caractères.');
                    return $this->redirectToRoute('app_simad_creation_cas');
                }

                $CasPV = $doctrine->getRepository('App\Entity\CasPV')->findOneBy(['numeroBNPV' => $NumBNPV]);
                if ($CasPV) {
                    $this->addFlash('error', sprintf('Le numéro du cas "%s" existe déjà dans la base de données.', $NumBNPV));
                    return $this->redirectToRoute('app_simad_creation_cas');
                }

                // --- ÉTAPE 4 : REQUÊTES BNPV & RÉCUPÉRATION ---
                $aerId = $requetesBnpvService->DonneAerId($NumBNPV);
                if (!$aerId) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', sprintf('Le numéro de cas "%s" n\'existe pas dans la BNPV.', $NumBNPV));
                    }
                    return $this->redirectToRoute('app_simad_creation_cas');
                }

                $mainDataRows = $requetesBnpvService->DonneMainData($aerId);
                if (empty($mainDataRows)) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', 'Aucune donnée détaillée trouvée pour ce cas dans la BNPV.');
                    }
                    return $this->redirectToRoute('app_simad_creation_cas');
                }
                $mainData = $mainDataRows[0];

                dump($mainData);

                $eiDataRows = $requetesBnpvService->DonneEIData($aerId);
                $medicDataRows = $requetesBnpvService->DonneMedicamentData($aerId);

                // --- ÉTAPE DE DÉBOGAGE (DUMP & DD) ---
                dump($eiDataRows);
                dd($medicDataRows);

                // Le code ci-dessous ne sera pas exécuté tant que le dd() est actif
                if ($typeFiche === FicheRecueilAnalyseurService::TYPE_SIMAD) {
                    $simad = $importSIMADService->CreationCasSIMAD($ficRec, $mainData, $eiDataRows, $medicDataRows, $requetesMeddraService);
                    $this->addFlash('success', sprintf('Fiche SIMAD détectée et pré-remplie avec succès pour le cas %s.', $NumBNPV));
                }

                return $this->redirectToRoute('app_simad_creation_cas');
            }
        }

        return $this->render('simad/creation_cas/creation_cas.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}