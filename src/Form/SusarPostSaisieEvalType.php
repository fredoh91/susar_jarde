<?php

namespace App\Form;

use App\Entity\Susar;
use App\Entity\MesureAction;
use App\Entity\IntervenantsANSM;
use Doctrine\ORM\EntityRepository;
use App\Form\SusarPostSaisieBaseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SusarPostSaisieEvalType extends SusarPostSaisieBaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        // dd($options['data']->getMesureAction()->getLibelle());
        $builder
            // ->add('master_id', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // // ->add('caseid')
            // // ->add('specificcaseid')
            // ->add('DLPVersion', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // // ->add('creationdate')
            // // ->add('statusdate')
            // ->add('studytitle', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // // ->add('sponsorstudynumb')
            // // ->add('num_eudract')
            // // ->add('pays_etude')
            // // ->add('TypeSusar')
            // ->add('indication', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('indication_eng', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('commentaire', TextareaType ::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('mesureAction', TextType::class, [
            //     'attr' => ['readonly' => true],
            //     'data' => $options['data']->getMesureAction()->getLibelle()
            // ])
            // ->add('mesureAction', EntTextTypetyType::class, [
            //     'class' => MesureAction::class,
            //     'choice_label' => 'Libelle',
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('mesureAction', EntityType::class, [
            //     'class' => MesureAction::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('Mes')
            //             ->where('Mes.inactif = 0')
            //             ->orderBy('Mes.OrdreTri', 'ASC');
            //     },
            //     'choice_label' => 'Libelle',
            // ])
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Susar::class,
        ]);
    }
}
