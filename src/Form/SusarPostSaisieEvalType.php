<?php

namespace App\Form;

use App\Entity\Susar;
// use App\Entity\MesureAction;
// use App\Entity\IntervenantsANSM;
// use Doctrine\ORM\EntityRepository;
use App\Form\SusarPostSaisieBaseType;
// use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SusarPostSaisieEvalType extends SusarPostSaisieBaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
        ->add('commentaire', TextareaType ::class, [
            'attr' => ['readonly' => true],
        ])
        ->add('mesureAction', TextType::class, [
            'attr' => ['readonly' => true],
            // 'data' => $options['data']->getMesureAction()->getLibelle()
            'data' => ($options['data']->getMesureAction()) ? $options['data']->getMesureAction()->getLibelle() : ''
        ])
        ->add('dateEvaluation', DateType::class, [
            'widget' => 'single_text',
            // 'label' => 'date d\'import : ',
            'format' => 'yyyy-MM-dd HH:mm:ss',
            // 'input' => 'string',
            'attr' => ['readonly' => true],
            'html5' => false,
        ])
        ->add('utilisateurEvaluation', TextType ::class, [
            'attr' => ['readonly' => true],
            
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
