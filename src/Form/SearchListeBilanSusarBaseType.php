<?php

namespace App\Form;

// use App\Entity\MesureAction;
// use App\Entity\IntervenantsANSM;
// use Doctrine\ORM\EntityRepository;
use App\Entity\SearchListeBilanSusar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\ResetType;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchListeBilanSusarBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debutStatusDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'début de date de création EUDRA : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
                ])
            ->add('finStatusDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'fin de date de création EUDRA : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
                ])
            ->add(
                'Recherche',
                SubmitType::class,
                [
                    'attr' => ['class' => 'btn btn-primary m-2'],
                    'label' => 'Rechercher',
                    'row_attr' => ['id' => 'recherche'],
                ]
            )
            ->add(
                'Reset',
                // ResetType::class,
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
            'data_class' => SearchListeBilanSusar::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
