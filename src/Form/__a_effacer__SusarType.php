<?php

namespace App\Form;

use App\Entity\Susar;
use App\Form\EditSusarBaseType;
use App\Entity\IntervenantsANSM;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

// class SusarType extends AbstractType
class SusarType extends EditSusarBaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('intervenantANSM', EntityType::class, [
                'class' => IntervenantsANSM::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('int')
                        ->where('int.inactif = 0')
                        ->orderBy('int.OrdreTri', 'ASC');
                },
                'choice_label' => 'DMM_pole_court',
            ])
            ->add('SaveAndStop', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary m-2'],
                'label' => 'Sauvegarder et quitter']
            )
            ->add('SaveAndNext', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary m-2'],
                'label' => 'Sauvegarder et suivant']
            )
            ;
            
            // ->add('master_id', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('studytitle', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('narratif', TextareaType ::class, [
            //     'attr' => [
            //         'readonly' => true,
            //         'rows' => 12,
            //     ],
                
            // ])
            // ->add('indication', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('indication_eng', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // ->add('caseid')
            // ->add('specificcaseid')
            // ->add('DLPVersion')
            // ->add('creationdate')
            // ->add('statusdate')
            // ->add('sponsorstudynumb')
            // ->add('num_eudract')
            // ->add('pays_etude')
            // ->add('TypeSusar')
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Susar::class,
        ]);
    }
}
