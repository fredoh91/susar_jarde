<?php

namespace App\Form;

use App\Entity\Glossaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlossaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('itemGlossaire')
            ->add('evaluateur')
            ->add('DP')
            ->add('DMM')
            ->add('pole_court')
            ->add('pole_long')
            ->add('Actif')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Glossaire::class,
        ]);
    }
}
