<?php

namespace App\Controller\CM;

use App\Entity\CasPV;
use App\Entity\CM\CM;
use App\Entity\CM\EMM;
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
    #[Route('/creation_cas_upload', name: 'app_cm_creation_cas_upload_fiche_recueil')]
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
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }

                $typeFiche = $analyseResult['type'];

                // --- ÉTAPE 2 : AIGUILLAGE & SÉCURITÉ CONTEXTUELLE ---
                if ($typeFiche === FicheRecueilAnalyseurService::TYPE_SIMAD) {
                    $this->addFlash('warning', 'Vous tentez d\'importer une fiche de type SIMAD. Ce module gère uniquement les fiches CM et EMM. Veuillez utiliser l\'espace dédié au traitement SIMAD de l\'application.');
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }

                // dump($typeFiche);

                $ficRec = [];

                if ($typeFiche === FicheRecueilAnalyseurService::TYPE_CM) {
                    $result = $importCMService->TraitementFichierWord($FicWordRecueilCM);
                    if (isset($result['error'])) {
                        $this->addFlash('error', $result['error']);
                        return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                    }
                    $ficRec = $result['Data_FicheRecueilCM'] ?? null;

                } elseif ($typeFiche === FicheRecueilAnalyseurService::TYPE_EMM) {
                    $result = $importEMMService->traitementFichierWord($FicWordRecueilCM);
                    if (isset($result['error'])) {
                        $this->addFlash('error', $result['error']);
                        return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                    }
                    $ficRec = $result['Data_FicheRecueilEMM'] ?? null;
                }

                // dump($ficRec);

                // --- ÉTAPE 3 : VALIDATION DES DONNÉES EXTRAITES ---
                if (!$ficRec) {
                    $this->addFlash('error', 'Aucun champ n\'a pu être extrait du document Word.');
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }

                $numCas = $ficRec['Num_Cas'] ?? $analyseResult['num_cas'];

                if (empty($numCas)) {
                    $this->addFlash('error', 'Numéro de cas absent ou illisible dans le document Word.');
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }

                $NumBNPV = trim($numCas);
                
                if (strlen($NumBNPV) > 14) {
                    $this->addFlash('error', 'Le numéro du cas ne doit pas comprendre plus de 14 caractères.');
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }

                $CasPV = $doctrine->getRepository('App\Entity\CasPV')->findOneBy(['numeroBNPV' => $NumBNPV]);
                if ($CasPV) {
                    $this->addFlash('error', sprintf('Le numéro du cas "%s" existe déjà dans la base de données.', $NumBNPV));
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }

                // --- ÉTAPE 4 : REQUÊTES BNPV & RÉCUPÉRATION ---
                $aerId = $requetesBnpvService->DonneAerId($NumBNPV);
                if (!$aerId) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', sprintf('Le numéro de cas "%s" n\'existe pas dans la BNPV.', $NumBNPV));
                    }
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }

                $mainDataRows = $requetesBnpvService->DonneMainData($aerId);
                if (empty($mainDataRows)) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', 'Aucune donnée détaillée trouvée pour ce cas dans la BNPV.');
                    }
                    return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                }
                $mainData = $mainDataRows[0];

                // dump($mainData);

                $eiDataRows = $requetesBnpvService->DonneEIData($aerId);
                $medicDataRows = $requetesBnpvService->DonneMedicamentData($aerId);
                 $antecedentsMedicaux = $requetesBnpvService->DonneAntecedentsData($aerId);
                 $indications = $requetesBnpvService->DonneIndicationsData($aerId);

                 // dd($antecedentsMedicaux, $indications);

                // dd($antecedentsMedicaux, $indications);

                // --- ÉTAPE DE DÉBOGAGE (DUMP & DD) ---
                // dump($eiDataRows);
                // dump($medicDataRows);

                // Le code ci-dessous ne sera pas exécuté tant que le dd() est actif
                if ($typeFiche === FicheRecueilAnalyseurService::TYPE_CM) {
                    // $cm = $importCMService->CreationCasCM($ficRec, $mainData, $eiDataRows, $medicDataRows, $requetesMeddraService, $antecedentsMedicaux, $indications);
                    $cm = $importCMService->CreationCasCM($ficRec, $mainData, $eiDataRows, $medicDataRows);
                    [$donComplCM, $cm] = $importCMService->CreationDonneesComplementairesCM($ficRec, $mainData, $eiDataRows, $medicDataRows, $indications, $antecedentsMedicaux, $cm);
                    // Ne pas associer l'entité dans le formulaire principal pour éviter l'erreur
                    // On laisse l'association pour la validation finale
                    $this->addFlash('success', sprintf('Fiche CM détectée et pré-remplie avec succès pour le cas %s.', $NumBNPV));
                    return $this->redirectToRoute('app_cm_creation_cas_creation', ['cas' => $cm->getId()]);

                } elseif ($typeFiche === FicheRecueilAnalyseurService::TYPE_EMM) {
                    $emm = $importEMMService->CreationCasEMM($ficRec, $mainData, $eiDataRows, $medicDataRows, $requetesMeddraService);
                    $this->addFlash('success', sprintf('Fiche EMM détectée et pré-remplie avec succès pour le cas %s.', $NumBNPV));
                    return $this->redirectToRoute('app_cm_creation_cas_creation', ['cas' => $emm->getId()]);
                }

                return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
            }
        }
        
        return $this->render('cm/creation_cas/creation_cas.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/creation_cas_creation/{cas}', name: 'app_cm_creation_cas_creation')]
    public function creationCas(
        CasPV $cas,
        Request $request, 
        EntityManagerInterface $em
        ): Response
    {
        // Vérification des droits d'accès
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Accès refusé.');
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
        
        // Vérification que l'utilisateur est le créateur du cas ou a les droits nécessaires
        if ($cas->getUserCreate() !== $user->getUserIdentifier() && 
            !in_array('ROLE_PHARVIGI_SURV_EVAL', $user->getRoles()) && 
            !in_array('ROLE_PHARVIGI_SURV_GEST', $user->getRoles())) {
            throw $this->createAccessDeniedException('Vous n\'avez pas les droits pour modifier ce cas.');
        }

        // Vérification que le statut actif du cas est bien en "brouillon"
        $statutCasPVRepository = $em->getRepository(\App\Entity\StatutCasPV::class);
        if ($statutCasPVRepository->isStatutActifIsBrouillon($cas) === false) {
            $this->addFlash('error', 'Le cas ne peut pas être enregistré car il n\'est pas dans un état brouillon.');
            return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
        }

        $now = new \DateTimeImmutable();

        // Création du formulaire en fonction du type d'entité
        if ($cas instanceof CM) {
            $form = $this->createForm(\App\Form\CM\CMOngletsCreationType::class, $cas);
            
            $form->handleRequest($request);
            
            // Vérifier quelle action a été choisie
            if ($form->isSubmitted()) {
                $requestData = $request->request->all();
                
                // Si le bouton "Enregistrer le cas marquant" a été cliqué
                if (isset($requestData['save'])) {
                    // Vérifier si le formulaire est valide
                    if ($form->isValid()) {
                        // recupération du statut brouillon
                        $statutBrouillon = $statutCasPVRepository->findOneBy([
                            'casPV' => $cas,
                            'StatutActif' => true,
                            'LibStatut' => 'brouillon',
                        ]);

                        // on le duplique pour le mettre en statut "creation"
                        if ($statutBrouillon) {

                            $statutBrouillon->setStatutActif(false);
                            $statutBrouillon->setDateDesactivation($now);
                            $statutBrouillon->setUserModif($userName);
                            $statutBrouillon->setUpdatedAt($now);
                            $em->persist($statutBrouillon);

                            $statutEnCours = new \App\Entity\StatutCasPV();
                            $statutEnCours->setCasPV($cas);
                            $statutEnCours->setLibStatut('creation');
                            $statutEnCours->setStatutActif(true);
                            $statutEnCours->setDateMiseEnPlace($now);
                            $statutEnCours->setUserCreate($userName);
                            $statutEnCours->setUserModif($userName);
                            $statutEnCours->setCreatedAt($now);
                            $statutEnCours->setUpdatedAt($now);

                            $em->persist($statutEnCours);   
                        }
                        // Validation du formulaire
                        $em->flush();
                        $this->addFlash('success', 'Les modifications du cas CM ont été enregistrées avec succès.');
                        return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
                    }
                }
                // Si le bouton "Annuler" a été cliqué
                elseif (isset($requestData['cancel'])) {
                    return $this->redirectToRoute('app_cm_creation_cas_annulation', ['cas' => $cas->getId()]);
                }
            }
            
            return $this->render('cm/creation_cas/form_creation_cas_cm.html.twig', [
                'form' => $form->createView(),
                'cas' => $cas,
            ]);
            
        } elseif ($cas instanceof EMM) {
            $form = $this->createForm(\App\Form\CM\EMMType::class, $cas);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                // Validation du formulaire EMM
                $em->flush();
                $this->addFlash('success', 'Les modifications du cas EMM ont été enregistrées avec succès.');
                return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
            }
            
            return $this->render('cm/creation_cas/form_creation_cas_emm.html.twig', [
                'form' => $form->createView(),
                'cas' => $cas,
            ]);
        }
        
        // Si le type d'entité n'est ni CM ni EMM
        $this->addFlash('error', 'Type de cas non supporté.');
        return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
    }

    #[Route('/creation_cas_annulation/{cas}', name: 'app_cm_creation_cas_annulation')]
    public function annulationCas(
        CasPV $cas,
        EntityManagerInterface $em
        ): Response
    {
        // Vérification des droits d'accès
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Accès refusé.');
        }
        
        // Vérification que l'utilisateur est le créateur du cas ou a les droits nécessaires
        if ($cas->getUserCreate() !== $user->getUserIdentifier() && 
            !in_array('ROLE_PHARVIGI_SURV_EVAL', $user->getRoles()) && 
            !in_array('ROLE_PHARVIGI_SURV_GEST', $user->getRoles())) {
            throw $this->createAccessDeniedException('Vous n\'avez pas les droits pour annuler ce cas.');
        }
        
        // Vérification que le cas est dans un état annulable, son statut actif doit être "brouillon"
        $statutCasPVRepository = $em->getRepository(\App\Entity\StatutCasPV::class);
        if ($statutCasPVRepository->isStatutActifIsBrouillon($cas) === false) {
            $this->addFlash('error', 'Le cas ne peut pas être annulé car il n\'est pas dans un état brouillon.');
            return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
        }

        $numBNPV = $cas->getNumeroBNPV();

        // Logique d'annulation : suppression des entités associées
        try {
            // Vérification du type d'entité pour gérer CM ou EMM
            if ($cas instanceof CM) {
                // Pour CM : suppression des statuts et données complémentaires
                foreach ($cas->getStatutCasPVs() as $statut) {
                    $em->remove($statut);
                }
                
                $donneesComplementaires = $cas->getDonneesComplementairesCM();
                if ($donneesComplementaires) {
                    $em->remove($donneesComplementaires);
                }
            } elseif ($cas instanceof EMM) {
                // Pour EMM : suppression des statuts
                foreach ($cas->getStatutCasPVs() as $statut) {
                    $em->remove($statut);
                }
            }
            
            // Suppression de l'objet principal
            $em->remove($cas);
            $em->flush();
            
            $this->addFlash('success', 'La création du cas ' . $numBNPV . ' a été annulée avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'annulation du cas' . $numBNPV . '.');
        }
        
        return $this->redirectToRoute('app_cm_creation_cas_upload_fiche_recueil');
    }
}