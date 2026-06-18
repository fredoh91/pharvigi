<?php

namespace App\Form\SIMAD;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadFicheRecueilSIMADType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('field_name')
            ->add('FicWordRecueilSIMAD', FileType::class, [
                'label' => 'Fichier Word "Fiche de recueil SIMAD" : ',
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
            ->add('ImportFile', SubmitType::class, [
                'label' => 'Importer le fichier',
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
