<?php

namespace App\Form;

use App\Entity\Works;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;

class WorksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('category', ChoiceType::class, [
                'choices'  => [
                    'Fenêtre' => 'Fenêtre',
                    'Porte' => 'Porte',
                    'Peinture' => 'Peinture',
                    'Rénovations' => 'Rénovations',
                    'Salon' => 'Salon',
                    'Cuisine' => 'Cuisine',
                    'Jardin' => 'Jardin',
                ],
                'placeholder' => 'Choisissez une catégorie',
                'label' => 'Catégorie',

            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Non' => '',
                    'Avant' => 'Avant',
                    'Après' => 'Après',
                ],
                'label' => 'Ajouter une étiquette',
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG or PNG)',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Works::class,
        ]);
    }
}
