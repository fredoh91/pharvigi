<?php

namespace App\Form\CM;

use App\Entity\EMM;
use App\Form\CasPVType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('avisCRPV', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Pour action' => 'Pour action',
                    'Pour information' => 'Pour information',
                ],
                'placeholder' => false
            ])
            ->add('MotifNonPresentation')
            // ->add('suiviEnquete')
            // ->add('ListeCRPV')
            ->add('MaitriseRisque_Commentaire')
            ->add('lettre', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    '' => '',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                ],
                'placeholder' => 'Sélectionnez une lettre'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer l\'EMM',
                // 'attr' => [
                //     'class' => 'btn btn-success btn-lg me-2'
                // ]
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Annuler',
                // 'attr' => [
                //     'class' => 'btn btn-secondary btn-lg',
                //     'onclick' => "return confirm('Êtes-vous sûr de vouloir annuler ce cas ?')"
                // ]
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EMM::class,
        ]);
    }
}
