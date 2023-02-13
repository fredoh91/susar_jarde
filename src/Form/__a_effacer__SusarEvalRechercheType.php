<?php

namespace App\Form;

use App\Entity\SusarEvalRecherche;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SusarEvalRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('master_id')
        //     ->add('DLPVersion')
        //     ->add('num_eudract')
        //     ->add('sponsorstudynumb')
        //     ->add('studytitle')
        //     ->add('productName')
        //     ->add('substanceName')
        //     ->add('indication')
        //     ->add('indication_eng')
        //     ->add('intervenantANSM')
        //     ->add('MesureAction')
        // ;
        $builder
        ->add('master_id')
        // ->add('caseid')
        // ->add('specificcaseid')
        ->add('DLPVersion')
        // ->add('creationdate')
        // ->add('statusdate')
        ->add('studytitle', TextType::class)
        ->add('sponsorstudynumb')
        ->add('num_eudract')
        // ->add('pays_etude')
        // ->add('TypeSusar')
        ->add('indication', TextType::class)
        ->add('indication_eng', TextType::class)
        ->add('productName', TextType::class)
        ->add('substanceName', TextType::class)
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
        ])
        ->add('mesureAction', EntityType::class, [
            'class' => MesureAction::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('Mes')
                    ->where('Mes.inactif = 0')
                    ->orderBy('Mes.OrdreTri', 'ASC');
            },
            'choice_label' => 'Libelle',
        ])
        ->add('recherche', SubmitType::class);
        // ->add('MesureAction')
    ;        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SusarEvalRecherche::class,
        ]);
    }
}
