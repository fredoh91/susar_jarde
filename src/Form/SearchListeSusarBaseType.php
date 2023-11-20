<?php

namespace App\Form;

use App\Entity\MesureAction;
use App\Entity\IntervenantsANSM;
use Doctrine\ORM\EntityRepository;
use App\Entity\SearchListeEvalSusar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\ResetType;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchListeSusarBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specificcaseid', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('worldWide_id', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('DLPVersion', IntegerType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('studytitle', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('sponsorstudynumb')
            ->add('num_eudract', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('indication', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('indication_eng', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('productName', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('substanceName', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
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
            ->add('mesureAction', EntityType::class, [
                'class' => MesureAction::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('Mes')
                        ->where('Mes.inactif = 0')
                        ->orderBy('Mes.OrdreTri', 'ASC');
                },
                'choice_label' => 'Libelle',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add(
                'recherche',
                SubmitType::class,
                [
                    'attr' => ['class' => 'btn btn-primary m-2'],
                    'label' => 'Rechercher',
                    'row_attr' => ['id' => 'recherche'],
                ]

            )
            ->add(
                'reset',
                SubmitType::class,
                [
                    'attr' => ['class' => 'btn btn-primary m-2'],
                    'label' => 'Reset',
                    'row_attr' => ['id' => 'reset'],
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchListeEvalSusar::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
