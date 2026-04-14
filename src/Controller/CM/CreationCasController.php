<?php

namespace App\Controller\CM;

use App\Form\CM\UploadFicheRecueilCMType;
use App\Service\ImportFicheRecueilCMService;
use App\Service\RequetesBnpvCMService;
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
        RequetesBnpvCMService $requetesService, 
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
                
                // dd($ficRec);

                    $aerId = $requetesService->DonneAerId($ficRec['Num_Cas']);
                    dd($aerId);
                //     if ($aerId) {
                //         $result["aerId"] = $aerId;
                //     } else {
                //         $this->addFlash('error', 'AER_No non trouvé dans la base BNPV.');
                //         return $this->redirectToRoute('app_cm_creation_cas');
                //     }
                // } else {
                //     $this->addFlash('error', 'Num_Cas non trouvé dans le document Word.');
                //     return $this->redirectToRoute('app_cm_creation_cas');
            
            }
        }

        return $this->render('cm/creation_cas/creation_cas.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
