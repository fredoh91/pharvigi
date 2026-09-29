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

class AnalyseRisqueCMType extends AnalyseRisqueType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('LibErmr')
            ->add('CommentErmr')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnalyseRisque::class,
        ]);
    }
}
