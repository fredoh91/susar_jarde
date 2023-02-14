<?php

namespace App\Form;

use App\Entity\TermeRechAttribDMMpole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TermeRechAttribDMMpoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DMM')
            ->add('pole_long')
            ->add('pole_court')
            ->add('TermeRech')
            ->add('Actif')
            ->add('TypeRech')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TermeRechAttribDMMpole::class,
        ]);
    }
}
