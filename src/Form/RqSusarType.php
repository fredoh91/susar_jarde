<?php

namespace App\Form;

use App\Entity\Susar;
// use App\Entity\IntervenantsANSM;
// use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RqSusarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
        // ->add('DateCreation', DateType::class, [
        //     'widget' => 'single_text',
        //     'label' => 'date d\'import : ',
        //     'format' => 'yyyy-MM-dd',
        //     'input' => 'string',
        //     ])
        ->add('DateStatus', DateType::class, [
            'widget' => 'single_text',
            'label' => 'date d\'import : ',
            'format' => 'yyyy-MM-dd',
            'input' => 'string',
            ])
        ->add('Recherche', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Susar::class,
        ]);
    }
}
