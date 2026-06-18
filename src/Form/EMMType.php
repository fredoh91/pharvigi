<?php

namespace App\Form;

use App\Entity\EMM;
use App\Form\CasPVType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EMMType extends CasPVType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            // ->add('TypeCasPV')
            // ->add('numeroBNPV')
            // ->add('problematique')
            // ->add('propositionCRPV')
            // ->add('conclusions')
            // ->add('presentation')
            // ->add('CRPV')
            // ->add('codeCRPV')
            // ->add('gravite')
            // ->add('deces')
            // ->add('miseEnJeuPronostic')
            // ->add('hospitalisation')
            // ->add('incapacite')
            // ->add('anomalieCongenitale')
            // ->add('autreSituation')
            // ->add('typologie')
            // ->add('dateArrivee', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('age')
            // ->add('sexe')
            // ->add('uniteAge')
            // ->add('effetIndesirable')
            // ->add('prequalificationDSURV')
            // ->add('motifPrequalification')
            // ->add('investigationDP')
            // ->add('echangeDMM_CRPV')
            // ->add('cluster')
            // ->add('finalise')
            // ->add('casPere')
            // ->add('lettre')
            // ->add('motifQualificationDMM')
            // ->add('SRE')
            // ->add('UserCreate')
            // ->add('UserModif')
            // ->add('CreatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('UpdatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('niveauRisqueFinal')
            // ->add('niveauRisquePGS')
            ->add('avisCRPV')
            ->add('MotifNonPresentation')
            ->add('suiviEnquete')
            ->add('ListeCRPV')
            ->add('MaitriseRisque_Commentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EMM::class,
        ]);
    }
}
