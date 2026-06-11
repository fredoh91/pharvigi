<?php

namespace App\Controller\CM;

use App\Form\CM\UploadFicheRecueilCMType;
use App\Service\ImportFicheRecueilCMService;
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
        ImportFicheRecueilCMService $importService, 
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
                $result = $importService->TraitementFichierWord($FicWordRecueilCM);
                if (isset($result['error'])) {
                    $this->addFlash('error', $result['error']);
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                if ($result['Data_FicheRecueilCM']) {
                    $ficRec = $result['Data_FicheRecueilCM'];
                } else {
                    $this->addFlash('error', 'Aucun champ extrait du document Word.');
                    return $this->redirectToRoute('app_cm_creation_cas');
                }
                dump($ficRec);
                if (!isset($ficRec['Num_Cas']) || empty($ficRec['Num_Cas'])) {
                    $this->addFlash('error', 'Numéro de cas absent ou illisible dans le document Word.');
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                $NumBNPV = trim($ficRec['Num_Cas']);
                // Vérif du numero BNPV
                //      - vérif taille
                if (strlen($NumBNPV) > 14) {
                    $this->addFlash('error', sprintf('Le numéro du cas ne doit pas compendre plus de 14 caractères.', $ficRec['Num_Cas']));
                    return $this->redirectToRoute('app_cm_creation_cas');
                }
                //      - vérif absence de ce numéro BNPV dans l'entité CasPV numeroBNPV
                $CasPV = $doctrine->getRepository('App\Entity\CasPV')->findOneBy(['numeroBNPV' => $NumBNPV]);
                if ($CasPV) {
                    $this->addFlash('error', sprintf('Le numéro du cas "%s" existe déjà dans la base de données.', $ficRec['Num_Cas']));
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                // Recherche du master_id 
                $aerId = $requetesBnpvService->DonneAerId($ficRec['Num_Cas']);
                if (!$aerId) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', sprintf('Le numéro de cas "%s" n\'existe pas dans la BNPV.', $ficRec['Num_Cas']));
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
                dump($mainData);

                $eiDataRows = $requetesBnpvService->DonneEIData($aerId);

                if (empty($eiDataRows)) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', 'Aucune donnée EI trouvée pour ce cas dans la BNPV.');
                    }
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                dump($eiDataRows);

                $medicDataRows = $requetesBnpvService->DonneMedicamentData($aerId);

                if (empty($medicDataRows)) {
                    if (!$requetesBnpvService->hasError()) {
                        $this->addFlash('error', 'Aucune donnée médicament trouvée pour ce cas dans la BNPV.');
                    }
                    return $this->redirectToRoute('app_cm_creation_cas');
                }

                dd($medicDataRows);
            }
        }

        return $this->render('cm/creation_cas/creation_cas.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
