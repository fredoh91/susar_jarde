<?php

namespace App\Form;

// use App\Entity\Susar;
use App\Entity\MesureAction;
use App\Entity\IntervenantsANSM;
use Doctrine\ORM\EntityRepository;
use App\Entity\SearchListeEvalSusar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchListeEvalSusarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('master_id', IntegerType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            // ->add('caseid', IntegerType::class,[
            //     'required' => false,
            //     'attr' => ['class' => 'chpRq'],
            //     ])
            // ->add('specificcaseid')
            ->add('DLPVersion', IntegerType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            // ->add('creationdate')
            // ->add('statusdate')
            ->add('studytitle', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('sponsorstudynumb')
            ->add('num_eudract')
            // ->add('pays_etude')
            // ->add('TypeSusar')
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
            // ->add('Commentaire')
            // ->add('intervenantANSM')
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
            ->add('debutDateAiguillage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'début de date d\'aiguillage : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('finDateAiguillage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'fin de date d\'aiguillage : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            // ->add('debutCreationDate', DateType::class, [
            //     'widget' => 'single_text',
            //     'label' => 'début de date de création EUDRA : ',
            //     'format' => 'yyyy-MM-dd',
            //     // 'input' => 'string',
            //     'required' => false,
            //     'attr' => ['class' => 'chpRq'],
            //     ])
            // ->add('finCreationDate', DateType::class, [
            //     'widget' => 'single_text',
            //     'label' => 'fin de date de création EUDRA : ',
            //     'format' => 'yyyy-MM-dd',
            //     // 'input' => 'string',
            //     'required' => false,
            //     'attr' => ['class' => 'chpRq'],
            //     ])
            ->add('debutDateEvaluation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'début de date d\'évaluation : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('finDateEvaluation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'fin de date d\'évaluation : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
            ])
            ->add('evalue', ChoiceType::class, [
                'choices'  => [
                    '' => null,
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
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
            // ->add('MesureAction')
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
