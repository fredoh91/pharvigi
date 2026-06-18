<?php

namespace App\Form;

use App\Entity\CasPV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CasPVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TypeCasPV')
            ->add('numeroBNPV')
            ->add('problematique')
            ->add('propositionCRPV')
            ->add('conclusions')
            ->add('presentation')
            ->add('CRPV')
            ->add('codeCRPV')
            ->add('gravite')
            ->add('deces')
            ->add('miseEnJeuPronostic')
            ->add('hospitalisation')
            ->add('incapacite')
            ->add('anomalieCongenitale')
            ->add('autreSituation')
            ->add('typologie')
            ->add('dateArrivee', null, [
                'widget' => 'single_text',
            ])
            ->add('age')
            ->add('sexe')
            ->add('uniteAge')
            ->add('effetIndesirable')
            ->add('prequalificationDSURV')
            ->add('motifPrequalification')
            ->add('investigationDP')
            ->add('echangeDMM_CRPV')
            ->add('cluster')
            ->add('finalise')
            ->add('casPere')
            ->add('lettre')
            ->add('motifQualificationDMM')
            ->add('SRE')
            ->add('UserCreate')
            ->add('UserModif')
            ->add('CreatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('UpdatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('niveauRisqueFinal')
            ->add('niveauRisquePGS')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CasPV::class,
        ]);
    }
}
