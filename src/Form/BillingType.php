<?php

namespace App\Form;

use App\Entity\Billing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('code_postal')
            ->add('city')
            ->add('creationDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('title')
            ->add('tva')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'DEVIS' => 'DEVIS',
                    'FACTURE' => 'FACTURE',
                ],
                'label' => 'Status',
                'expanded' => false,
                'multiple' => false,
            ])            ->add('billingItems', CollectionType::class, [
                'entry_type' => BillingItemType::class,
                'allow_add' => true,
                'by_reference' => false,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
        ]);
    }
}
