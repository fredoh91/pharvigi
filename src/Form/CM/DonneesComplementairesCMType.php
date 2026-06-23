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
            ->add('EI_Attendu', CheckboxType::class, ['required' => false])
            ->add('EI_Inattendu', CheckboxType::class, ['required' => false])
            ->add('PlausibilitePharma', CheckboxType::class, ['required' => false])
            ->add('TabCliniInhab', CheckboxType::class, ['required' => false])
            ->add('TabCliniInhab_comment', TextareaType::class, ['required' => false])
            ->add('ChronoEvo', CheckboxType::class, ['required' => false])
            ->add('SemioEvo', CheckboxType::class, ['required' => false])
            ->add('SemioEvo_comment', TextareaType::class, ['required' => false])
            ->add('ContexPriseMedic', CheckboxType::class, ['required' => false])
            ->add('ContexPriseMedic_comment', TextareaType::class, ['required' => false])
            ->add('SeulMedicSusp', CheckboxType::class, ['required' => false])
            ->add('RisqueRecu', CheckboxType::class, ['required' => false])
            ->add('RisqueRecu_comment', TextareaType::class, ['required' => false])
            ->add('AutreCasBNPV', CheckboxType::class, ['required' => false])
            ->add('AutreCasBNPV_comment', TextareaType::class, ['required' => false])
            ->add('AutreCasVigylise', CheckboxType::class, ['required' => false])
            ->add('AutreCasVigylise_comment', TextareaType::class, ['required' => false])
            ->add('ParticulaMedic', CheckboxType::class, ['required' => false])
            ->add('ParticulaMedic_comment', TextareaType::class, ['required' => false])
            ->add('RisqueDocuLitt', CheckboxType::class, ['required' => false])
            ->add('RisqueDocuLitt_comment', TextareaType::class, ['required' => false])
            ->add('ContextMedia', CheckboxType::class, ['required' => false])
            ->add('ContextMedia_comment', TextareaType::class, ['required' => false])
            ->add('PersistProb', CheckboxType::class, ['required' => false])
            ->add('PersistProb_comment', TextareaType::class, ['required' => false])
            ->add('ASMR_SMR', CheckboxType::class, ['required' => false])
            ->add('ASMR_SMR_comment', TextareaType::class, ['required' => false])
            ->add('UtilHorsAMM_RTU_ATU', CheckboxType::class, ['required' => false])
            ->add('UtilHorsAMM_RTU_ATU_Choix', TextareaType::class, ['required' => false])
            ->add('Autre', CheckboxType::class, ['required' => false])
            ->add('Autre_comment', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DonneesComplementairesCM::class,
        ]);
    }
}