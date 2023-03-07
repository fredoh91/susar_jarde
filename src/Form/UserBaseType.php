<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir une adresse email'
                    ])
                ],
                'attr' => ['readonly' => false],
                'required' => true,
            ])

            ->add('Prenom', TextType ::class, [
                'label' => 'Prénom : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un prénom'
                    ])
                ],
                'attr' => ['readonly' => false],
                'required' => true,
            ])

            ->add('Nom', TextType ::class, [
                'label' => 'Nom : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un nom'
                    ])
                ],
                'attr' => ['readonly' => false],
                'required' => true,
            ])
            ->add('UserName', TextType ::class, [
                'label' => 'Username : ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un username'
                    ])
                ],
                'attr' => ['readonly' => false],
                'required' => true,
            ])
            // ->add('plainPassword', PasswordType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'label' => 'Mot de passe : ',
            //     'mapped' => false,
            //     'attr' => ['autocomplete' => 'new-password'],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Please enter a password',
            //         ]),
            //         new Length([
            //             'min' => 6,
            //             'minMessage' => 'Your password should be at least {{ limit }} characters',
            //             // max length allowed by Symfony for security reasons
            //             'max' => 4096,
            //         ]),
            //     ],
            // ])
            // ->add('id', TextType ::class, [
            //     'attr' => ['readonly' => true],
            // ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_DMFR_ADMIN' => 'ROLE_DMFR_ADMIN',
                    'ROLE_DMFR_REF' => 'ROLE_DMFR_REF',
                    'ROLE_DMFR_GEST' => 'ROLE_DMFR_GEST',
                    'ROLE_SURV_ADMIN' => 'ROLE_SURV_ADMIN',
                    'ROLE_SURV_PILOTEVEC' => 'ROLE_SURV_PILOTEVEC',
                    'ROLE_DMM_EVAL' => 'ROLE_DMM_EVAL',
                    // 'ROLE_USER' => 'ROLE_USER',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôle(s)'
            ])

            // ->add('Valider', SubmitType::class, [
            //     'attr' => ['class' => 'btn btn-primary m-2'],
            //     'label' => 'Valider']
            // )
            // ->add('Annuler', SubmitType::class, [
            //     'attr' => ['class' => 'btn btn-primary m-2'],
            //     'label' => 'Annuler']
            // )
            // ->add('Inscription', SubmitType::class, [
            //     'attr' => ['class' => 'btn btn-primary btn-lg my-3'],
            //     'label' => 'Inscription']
            // )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
