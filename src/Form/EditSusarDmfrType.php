<?php

namespace App\Form;

use App\Entity\Susar;
use App\Entity\MesureAction;
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

class EditSusarDmfrType extends EditSusarBaseType
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
            ->add('Save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary m-2'],
                'label' => 'Sauvegarder']
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Susar::class,
        ]);
    }
}
