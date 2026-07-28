<?php

namespace App\Form\CM;

use App\Entity\CM\CM;
use App\Entity\ListeCSP;
use App\Form\CasPVType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CMType extends CasPVType
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
                    '' => '',
                    'Pour action' => 'Pour action',
                    'Pour information' => 'Pour information',
                ],
                'placeholder' => 'Avis CRPV'
            ])
            ->add('MotifNonPresentation')
            ->add('suiviEnquete')
            ->add('ListeCRPV')
            ->add('MaitriseRisque_Commentaire')
            ->add('lettre', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    '' => '',
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                ],
                'placeholder' => 'Sélectionnez une lettre'
            ])
            // ->add('dateCSP', EntityType::class, [
            //     'class' => ListeCSP::class,
            //     'choice_label' => function (\App\Entity\ListeCSP $listeCSP): string {
            //         return $listeCSP->getDateCSP()?->format('d/m/Y') ?? '(date inconnue)';
            //     },
            //     'query_builder' => function ($repository) {
            //         return $repository->findDatesCSPQueryBuilderByTypeCSP('CSP_SIGNAL',20);
            //     },
            //     'mapped' => false,
            //     'multiple' => false,
            // ])
            // ->add('DonneesComplementairesCM', EntityType::class, [
            //     'class' => DonneesComplementairesCM::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CM::class,
        ]);
    }
}
