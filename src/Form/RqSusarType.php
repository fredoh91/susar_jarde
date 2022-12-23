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



        // $defaultData = ['message' => 'Saisissez une date d\'import'];
        // $form = $this->createFormBuilder($defaultData)
        // ->add('DateCreation', DateType::class, [
        //     'widget' => 'single_text',
        //     'label' => 'date d\'import : ',
        //     'format' => 'yyyy-MM-dd',
        //     'input' => 'string',
        //     ])
        // ->add('Recherche', SubmitType::class)
        // ->getForm();


        $builder
        ->add('DateCreation', DateType::class, [
            'widget' => 'single_text',
            'label' => 'date d\'import : ',
            'format' => 'yyyy-MM-dd',
            'input' => 'string',
            ])
        ->add('Recherche', SubmitType::class);
            // ->add('master_id', TextType::class, [
            //     'attr' => ['readonly' => true],
            // ])
            // // ->add('caseid')
            // // ->add('specificcaseid')
            // // ->add('DLPVersion')
            // // ->add('creationdate')
            // // ->add('statusdate')
            // // ->add('studytitle')
            // // ->add('sponsorstudynumb')
            // // ->add('num_eudract')
            // // ->add('pays_etude')
            // // ->add('TypeSusar')
            // // ->add('indication')
            // ->add('intervenantANSM', EntityType::class, [
            //     // looks for choices from this entity
            //     'class' => IntervenantsANSM::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('int')
            //             ->where('int.inactif = 0')
            //             ->orderBy('int.OrdreTri', 'ASC');
            //     },
            //     // uses the User.username property as the visible option string
            //     'choice_label' => 'DMM_pole_court',
            
            //     // used to render a select box, check boxes or radios
            //     // 'multiple' => true,
            //     // 'expanded' => true,
            // ])
            // ->add('SaveAndStop', SubmitType::class, [
            //     'attr' => ['class' => 'btn btn-primary m-2'],
            //     'label' => 'Sauvegarder et quitter']
            // )
            // ->add('SaveAndNext', SubmitType::class, [
            //     'attr' => ['class' => 'btn btn-primary m-2'],
            //     'label' => 'Sauvegarder et suivant']
            // );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Susar::class,
        ]);
    }
}
