<?php

namespace App\Controller\CM;

use App\Entity\CasPV;
use App\Entity\CM\CM;
use App\Form\CM\CMOngletsDetailType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GestionCasController extends AbstractController
{
    #[Route('/detail_cas/{idCasPV}', name: 'app_cm_detail_cas')]
    public function detailCas(
        int $idCasPV,
        Request $request, 
        EntityManagerInterface $em
        ): Response
    {
        // Récupération de l'entité CasPV par ID
        $cas = $em->find(CasPV::class, $idCasPV);
        
        // Vérification si l'entité existe
        if (!$cas) {
            throw new NotFoundHttpException('Le cas demandé, avec l\'id ' . $idCasPV . ' n\'existe pas.');
        }

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
        /*if ($casEntity->getUserCreate() !== $user->getUserIdentifier() && 
            !in_array('ROLE_PHARVIGI_SURV_EVAL', $user->getRoles()) && 
            !in_array('ROLE_PHARVIGI_SURV_GEST', $user->getRoles())) {
            throw $this->createAccessDeniedException('Vous n\'avez pas les droits pour modifier ce cas.');
        }*/

        // Création du formulaire en fonction du type d'entité
        $form = null;
        if ($cas instanceof CM) {
            $form = $this->createForm(CMOngletsDetailType::class, $cas);

            $form->handleRequest($request);
        }
            
        // Récupération des dates de ListeCSP associées au cas
        $datesCSP = [];
        foreach ($cas->getAttributionCSPs() as $attribution) {
            $listeCSP = $attribution->getListeCSP();
            if ($listeCSP && $listeCSP->getDateCSP()) {
                $datesCSP[] = [
                    'date' => $listeCSP->getDateCSP(),
                    'type' => $listeCSP->getTypeCSP(),
                ];
            }
        }

        $lstProduitsCasPV = $cas->getProduits();

        
        return $this->render('cm/gestion_cas/detail.html.twig', [
                'form' => $form ? $form->createView() : null,
                'cas' => $cas,
                'datesCSP' => $datesCSP,
                'lstProduitsCasPV' => $lstProduitsCasPV,
                'type_cas_pv' => $cas->getTypeCasPV(),
                'routeSource' => 'app_cm_detail_cas',
        ]);
    }
}
