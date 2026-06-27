<?php

namespace App\Form;

use App\Entity\CasPV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CasPVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TypeCasPV', null, [
                'disabled' => true,
            ])
            ->add('numeroBNPV', null, [
                'disabled' => true,
            ])
            ->add('problematique')
            ->add('propositionCRPV')
            ->add('conclusions')
            ->add('presentation')
            ->add('CRPV')
            ->add('codeCRPV')
            ->add('gravite', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'placeholder' => false
            ])
            ->add('deces', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'placeholder' => false
            ])
            ->add('miseEnJeuPronostic', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'placeholder' => false
            ])
            ->add('hospitalisation', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'placeholder' => false
            ])
            ->add('incapacite', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'placeholder' => false
            ])
            ->add('anomalieCongenitale', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'placeholder' => false
            ])
            ->add('autreSituation', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'placeholder' => false
            ])
            ->add('typologie', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Effet indésirable' => 'Effet indésirable',
                    'Interaction' => 'Interaction',
                    'Surdosage' => 'Surdosage',
                    'Grossesse' => 'Grossesse',
                    'Allaitement' => 'Allaitement',
                    'Sevrage' => 'Sevrage',
                    'Surdosage volontaire' => 'Surdosage volontaire',
                    'Surdosage accidentel' => 'Surdosage accidentel',
                    'Erreur médicamenteuse' => 'Erreur médicamenteuse',
                    'Erreur médicamenteuse sans effet indésirable' => 'Erreur médicamenteuse sans effet indésirable',
                    'Pharmacodépendance' => 'Pharmacodépendance',
                    'Autre' => 'Autre',
                    'Exposition professionnelle' => 'Exposition professionnelle',
                ],
                'placeholder' => false
            ])
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
            // ->add('UserCreate')
            // ->add('UserModif')
            // ->add('CreatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('UpdatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('niveauRisqueFinal')
            ->add('niveauRisquePGS')
            ->add('FlConfirmMedicale', CheckboxType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CasPV::class,
        ]);
    }
}
