<?php

namespace App\Form;

use App\Entity\AnalyseRisque;
use App\Entity\CasPV;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnalyseRisqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LibCritereGravite')
            ->add('LibCritereInhab')
            ->add('LibTypePopulation')
            ->add('LibSuiteJud')
            ->add('LibMediatisation')
            ->add('LibProbSensTutelle')
            ->add('LibProbSensPartenaires')
            ->add('LibProduitSurveillance')
            ->add('ProdSurv_SurvRenforcee')
            ->add('ProdSurv_Enquete')
            ->add('ProdSurv_ATU_RTU')
            ->add('CommentCritereInhab')
            ->add('CommentContexte')
            ->add('CommentProduitSurveillance')
            ->add('LibPopulationExposee')
            ->add('CommentPopulationExposee')
            ->add('LibDasBnpv')
            ->add('CommentDasBnpv')
            // ->add('LibErmr')
            // ->add('CommentErmr')
            ->add('LibAutreCas')
            ->add('CommentAutreCas')
            ->add('LibSigEu')
            ->add('CommentSigEu')
            ->add('CommentGeneral')
            // ->add('UserCreate')
            // ->add('UserModif')
            // ->add('CreatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('UpdatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('DateCalcul', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('CritereGravite_Score')
            ->add('CritereGravite_Poids')
            ->add('CarInhabituel_Score')
            ->add('CarInhabituel_Poids')
            ->add('TypePopulation_Score')
            ->add('TypePopulation_Poids')
            ->add('SuiteJud_Score')
            ->add('SuiteJud_Poids')
            ->add('Mediatisation_Score')
            ->add('Mediatisation_Poids')
            ->add('ProbSensTutelle_Score')
            ->add('ProbSensTutelle_Poids')
            ->add('ProbSensPartenaires_Score')
            ->add('ProbSensPartenaires_Poids')
            ->add('ProduitSurveillance_Score')
            ->add('ProduitSurveillance_Poids')
            ->add('PopulationExposee_Score')
            ->add('PopulationExposee_Poids')
            ->add('DASBNPV_eRMR_Score')
            ->add('DASBNPV_eRMR_Poids')
            ->add('CM_SigEU_Score')
            ->add('CM_SigEU_Poids')
            ->add('ScoreHR')
            ->add('niveauRisqueCalcule')
            // ->add('OccurenceEM_Score')
            // ->add('OccurenceEM_Poids')
            ->add('CommentaireDMM')
            // ->add('Produits', EntityType::class, [
            //     'class' => Produits::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('CasPV', EntityType::class, [
            //     'class' => CasPV::class,
            //     'choice_label' => 'id',
            // ])
            ->add('Produits', HiddenType::class)
            ->add('CasPV', HiddenType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnalyseRisque::class,
        ]);
    }
}
