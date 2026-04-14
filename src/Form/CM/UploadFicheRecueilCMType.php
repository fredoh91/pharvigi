<?php

namespace App\Form\CM;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadFicheRecueilCMType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('field_name')
            ->add('FicWordRecueilCM', FileType::class, [
                'label' => 'Fichier Word "Fiche de recueil CM" : ',
                'mapped' => false,
                'required' => true,

                // 'constraints' => [
                //     new File([
                //         // 'maxSize' => '1024k',
                //         'mimeTypes' => [
                //             // 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                //             'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                //             'application/vnd.ms-excel',
                //         ],
                //         'mimeTypesMessage' => 'Merci de sélectionner un fichier Excel valide.',
                //     ])
                // ],
            ])
            ->add('ImportFile', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
