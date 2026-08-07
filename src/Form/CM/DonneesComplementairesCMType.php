<?php

namespace App\Form\CM;

use App\Entity\CM\DonneesComplementairesCM;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonneesComplementairesCMType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumeroBNPV')
            ->add('SpecialiteDCI')
            ->add('EffetsIndesirables')
            ->add('Lettre')
            ->add('EI_Attendu', CheckboxType::class, [
                'required' => false,
                'label' => 'EI attendu',
                ])
            ->add('EI_Inattendu', CheckboxType::class, [
                'required' => false,
                'label' => 'EI inattendu',
            ])
            ->add('Problematique', TextareaType::class, ['required' => false])
            ->add('PlausibilitePharma', CheckboxType::class, [
                'required' => false,
                'label' => 'Plausibilité pharmacologique',
                ])
            ->add('TabCliniInhab', CheckboxType::class, [
                'required' => false,
                'label' => 'Tableau clinique inhabituel (sévérité ...) : à documenter',
            ])
            ->add('TabCliniInhab_comment', TextareaType::class, ['required' => false])
            ->add('ChronoEvo', CheckboxType::class, [
                'required' => false,
                'label' => 'Chronologie évocatrice',
            ])
            ->add('SemioEvo', CheckboxType::class, [
                'required' => false,
                'label' => 'Sémiologie évocatrice (explicitez)',
            ])
            ->add('SemioEvo_comment', TextareaType::class, ['required' => false])
            ->add('ContexPriseMedic', CheckboxType::class, [
                'required' => false,
                'label' => 'Contexte particulier de prise du médicament (explicitez)',
            ])
            ->add('ContexPriseMedic_comment', TextareaType::class, ['required' => false])
            ->add('SeulMedicSusp', CheckboxType::class, [
                'required' => false,
                'label' => 'Seul médicament suspect',
            ])
            ->add('RisqueRecu', CheckboxType::class, [
                'required' => false,
                'label' => 'Risque de récurrence (explicitez)',
            ])
            ->add('RisqueRecu_comment', TextareaType::class, ['required' => false])
            ->add('Cluster', CheckboxType::class, ['required' => false])
            ->add('AutreCasBNPV', CheckboxType::class, [
                'required' => false,
                'label' => 'Autre cas dans la BNPV (précisez le mode de requête, le nombre, les numéros des cas et les décrire brièvement)',
                ])
            ->add('AutreCasBNPV_comment', TextareaType::class, ['required' => false])
            ->add('AutreCasVigylise', CheckboxType::class, [
                'required' => false,
                'label' => 'Autre cas dans Vigylise (précisez le mode de requête, le nombre, l\'origine si France et décrivez brièvement l\'EI)',
            ])
            ->add('AutreCasVigylise_comment', TextareaType::class, ['required' => false])
            ->add('ParticulaMedic', CheckboxType::class, [
                'required' => false,
                'label' => 'Particularité du médicament (précisez la classe pharmacologique, voie d\'administration, forma galénique, marge thérapeutique étroite, ...)',
            ])
            ->add('ParticulaMedic_comment', TextareaType::class, ['required' => false])
            ->add('RisqueDocuLitt', CheckboxType::class, [
                'required' => false,
                'label' => 'Risque documenté dans la littérature (indiquez les références et présentez succintement les conclusions)',
            ])
            ->add('RisqueDocuLitt_comment', TextareaType::class, ['required' => false])
            ->add('ContextMedia', CheckboxType::class, [
                'required' => false,
                'label' => 'Contexte médiatique local (précisez le cas échéant)',
            ])
            ->add('ContextMedia_comment', TextareaType::class, ['required' => false])
            ->add('PersistProb', CheckboxType::class, [
                'required' => false,
                'label' => 'Persistance de la problématique malgré les mesures prises',
            ])
            ->add('PersistProb_comment', TextareaType::class, ['required' => false])
            ->add('ASMR_SMR', CheckboxType::class, [
                'required' => false,
                'label' => 'ASMR/SMR du produit dans l\'indication si AMM',
            ])
            ->add('ASMR_SMR_comment', TextareaType::class, ['required' => false])
            ->add('UtilHorsAMM_RTU_ATU', CheckboxType::class, [
                'required' => false,
                'label' => 'Utilisation hors AMM / hors RTU/ hors ATU',
            ])
            ->add('UtilHorsAMM_RTU_ATU_Choix', TextareaType::class, ['required' => false])
            ->add('Autre', CheckboxType::class, [
                'required' => false,
                'label' => 'Autre',
            ])
            ->add('Autre_comment', TextareaType::class, ['required' => false])
            ->add('CmPourInfo', CheckboxType::class, [
                'required' => false,
                'label' => 'Cas marquant pour information',
            ])
            ->add('CmPourInfo_comment', TextareaType::class, ['required' => false])
            ->add('SignalPotentiel', CheckboxType::class, [
                'required' => false,
                'label' => 'Signal potentiel à investiguer',
            ])
            ->add('SignalPotentiel_comment', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DonneesComplementairesCM::class,
        ]);
    }
}