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

class SearchListeSusarDmfrType extends SearchListeSusarBaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder

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
            ->add('debutCreationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'début de date de création EUDRA : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
                ])
            ->add('finCreationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'fin de date de création EUDRA : ',
                'format' => 'yyyy-MM-dd',
                // 'input' => 'string',
                'required' => false,
                'attr' => ['class' => 'chpRq'],
                ])
            ->add('aiguille', ChoiceType::class, [
                'choices'  => [
                    '' => null,
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'attr' => ['class' => 'chpRq'],
            ])
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
