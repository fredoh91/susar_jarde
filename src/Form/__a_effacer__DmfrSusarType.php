<?php

namespace App\Form;

use App\Entity\Susar;
use App\Entity\MesureAction;
use App\Entity\IntervenantsANSM;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DmfrSusarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('master_id', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            // ->add('caseid')
            // ->add('specificcaseid')
            ->add('DLPVersion', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            // ->add('creationdate')
            // ->add('statusdate')
            ->add('studytitle', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('productname', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('substancename', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            // ->add('sponsorstudynumb')
            // ->add('num_eudract')
            // ->add('pays_etude')
            // ->add('TypeSusar')
            ->add('indication', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('indication_eng', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            // ->add('commentaire', TextareaType ::class, [
            //     'attr' => ['readonly' => false],
            // ])
            ->add('intervenantANSM', EntityType::class, [
                'class' => IntervenantsANSM::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('int')
                        ->where('int.inactif = 0')
                        ->orderBy('int.OrdreTri', 'ASC');
                },
                'choice_label' => 'DMM_pole_court',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            // ->add('mesureAction', EntityType::class, [
            //     'class' => MesureAction::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('Mes')
            //             ->where('Mes.inactif = 0')
            //             ->orderBy('Mes.OrdreTri', 'ASC');
            //     },
            //     'choice_label' => 'Libelle',
            // ])
            ->add('Save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary m-2'],
                'label' => 'Sauvegarder']
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Susar::class,
        ]);
    }
}
