<?php

namespace App\Form;

use App\Entity\Susar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SusarPostSaisieBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('master_id', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('specificcaseid', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('DLPVersion', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('pays_survenue', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('studytitle', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('num_eudract', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('worldWide_id', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('indication', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('indication_eng', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('intervenantANSM', TextType::class, [
                'attr' => ['readonly' => true],
                'data' => ($options['data']->getIntervenantANSM()) ? $options['data']->getIntervenantANSM()->getDMMPoleCourt() : ''
            ])
            ->add('productname', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('substancename', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('substancename', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('narratif', TextareaType ::class, [
                'attr' => [
                    'readonly' => true,
                    'rows' => 12,
                ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Susar::class,
        ]);
    }
}
