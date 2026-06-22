<?php

namespace App\Controller\CM;

use App\Form\CM\UploadFicheRecueilCMType;
use App\Service\FicheRecueilAnalyseurService;
use App\Service\ImportFicheRecueilCMService;
use App\Service\ImportFicheRecueilEMMService;
use App\Service\RequetesBnpvCMService;
use App\Service\RequetesMeddraService;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class CreationCasController extends AbstractController
{
    #[Route('/creation_cas', name: 'app_cm_creation_cas')]
    public function uploadFicheRecueilCM(
        Request $request, 
        FicheRecueilAnalyseurService $analyseurService,
        ImportFicheRecueilCMService $importCMService, 
        ImportFicheRecueilEMMService $importEMMService,
        RequetesBnpvCMService $requetesBnpvService, 
        RequetesMeddraService $requetesMeddraService, 
        ManagerRegistry $doctrine,
        EntityManagerInterface $em, 
        AuthenticationUtils $authenticationUtils
        ): Response
    {
        $form = $this->createForm(UploadFicheRecueilCMType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $FicWordRecueilCM = $form->get('FicWordRecueilCM')->getData();
            
            if ($FicWordRecueilCM) {
                
                // --- ÉTAPE 1 : PRÉ-ANALYSE DU FICHIER ---
                $analyseResult = $analyseurService->analyserFichier($FicWordRecueilCM);

                if (!$analyseResult['valide']) {
                    $this->addFlash('error', $analyseResult['error']);
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                $typeFiche = $analyseResult['type'];

                // --- ÉTAPE 2 : AIGUILLAGE & SÉCURITÉ CONTEXTUELLE ---
                if ($typeFiche === FicheRecueilAnalyseurService::TYPE_SIMAD) {
                    $this->addFlash('warning', 'Vous tentez d\'importer une fiche de type SIMAD. Ce module gère uniquement les fiches CM et EMM. Veuillez utiliser l\'espace dédié au traitement SIMAD de l\'application.');
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                // dump($typeFiche);

                $ficRec = [];

                if ($typeFiche === FicheRecueilAnalyseurService::TYPE_CM) {
                    $result = $importCMService->TraitementFichierWord($FicWordRecueilCM);
                    if (isset($result['error'])) {
                        $this->addFlash('error', $result['error']);
                        return $this->redirectToRoute('app_cm_creation_cas');
                    }
                    $ficRec = $result['Data_FicheRecueilCM'] ?? null;

                } elseif ($typeFiche === FicheRecueilAnalyseurService::TYPE_EMM) {
                    $result = $importEMMService->traitementFichierWord($FicWordRecueilCM);
                    if (isset($result['error'])) {
                        $this->addFlash('error', $result['error']);
                        return $this->redirectToRoute('app_cm_creation_cas');
                    }
                    $ficRec = $result['Data_FicheRecueilEMM'] ?? null;
                }

                // dump($ficRec);

                // --- ÉTAPE 3 : VALIDATION DES DONNÉES EXTRAITES ---
                if (!$ficRec) {
                    $this->addFlash('error', 'Aucun champ n\'a pu être extrait du document Word.');
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                $numCas = $ficRec['Num_Cas'] ?? $analyseResult['num_cas'];

                if (empty($numCas)) {
                    $this->addFlash('error', 'Numéro de cas absent ou illisible dans le document Word.');
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                $NumBNPV = trim($numCas);
                
                if (strlen($NumBNPV) > 14) {
                    $this->addFlash('error', 'Le numéro du cas ne doit pas comprendre plus de 14 caractères.');
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                $CasPV = $doctrine->getRepository('App\Entity\CasPV')->findOneBy(['numeroBNPV' => $NumBNPV]);
                if ($CasPV) {
                    $this->addFlash('error', sprintf('Le numéro du cas "%s" existe déjà dans la base de données.', $NumBNPV));
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                // --- ÉTAPE 4 : REQUÊTES BNPV & RÉCUPÉRATION ---
                $aerId = $requetesBnpvService->DonneAerId($NumBNPV);
                if (!$aerId) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', sprintf('Le numéro de cas "%s" n\'existe pas dans la BNPV.', $NumBNPV));
                    }
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                $mainDataRows = $requetesBnpvService->DonneMainData($aerId);
                if (empty($mainDataRows)) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', 'Aucune donnée détaillée trouvée pour ce cas dans la BNPV.');
                    }
                    return $this->redirectToRoute('app_cm_creation_cas');
                }
                $mainData = $mainDataRows[0];

                // dump($mainData);

                $eiDataRows = $requetesBnpvService->DonneEIData($aerId);
                $medicDataRows = $requetesBnpvService->DonneMedicamentData($aerId);

                // --- ÉTAPE DE DÉBOGAGE (DUMP & DD) ---
                // dump($eiDataRows);
                // dump($medicDataRows);

                // Le code ci-dessous ne sera pas exécuté tant que le dd() est actif
                if ($typeFiche === FicheRecueilAnalyseurService::TYPE_CM) {
                    $cm = $importCMService->CreationCasCM($ficRec, $mainData, $eiDataRows, $medicDataRows, $requetesMeddraService);
                    dd($cm);
                    $form = $this->createForm(\App\Form\CM\CMType::class, $cm);
                    $this->addFlash('success', sprintf('Fiche CM détectée et pré-remplie avec succès pour le cas %s.', $NumBNPV));
                    return $this->render('cm/creation_cas/form_creation_cas_cm.html.twig', [
                        'form' => $form->createView(),
                    ]);

                } elseif ($typeFiche === FicheRecueilAnalyseurService::TYPE_EMM) {
                    $emm = $importEMMService->CreationCasEMM($ficRec, $mainData, $eiDataRows, $medicDataRows, $requetesMeddraService);
                    dd($emm);
                    $form = $this->createForm(\App\Form\CM\EMMType::class, $emm);
                    $this->addFlash('success', sprintf('Fiche EMM détectée et pré-remplie avec succès pour le cas %s.', $NumBNPV));
                    return $this->render('cm/creation_cas/form_creation_cas_emm.html.twig', [
                        'form' => $form->createView(),
                    ]);
                }

                return $this->redirectToRoute('app_cm_creation_cas');
            }
        }

        return $this->render('cm/creation_cas/creation_cas.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}