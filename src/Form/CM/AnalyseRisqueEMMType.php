<?php

namespace App\Form\CM;

use App\Entity\AnalyseRisque;
// use App\Entity\CasPV;
// use App\Entity\Produits;
use App\Form\AnalyseRisqueType;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnalyseRisqueEMMType extends AnalyseRisqueType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('LibOccurrenceEM')
            ->add('CommentOccurrenceEM')
            ->add('OccurenceEM_Score')
            ->add('OccurenceEM_Poids')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnalyseRisque::class,
        ]);
    }
}
