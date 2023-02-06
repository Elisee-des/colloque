<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class editionPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', RepeatedType::class, [
            "type" => PasswordType::class,
            "first_options" => [
                "label" => "Nouveau mot de passe",
                'attr' => [
                    'autocomplete' => 'new-password',
                    "class" => "form-control mb-3"
                ]
            ],
            "second_options" => [
                "label" => "Repeter le mot de passe ",
                'attr' => [
                    'autocomplete' => 'new-password',
                    "class" => "form-control mb-3"
                ]
            ],
            "invalid_message" => "Mot de passe non identique",
        ])
        ->add('Modifier', SubmitType::class, [
            "attr" => [
                "class" => "btn btn-outline-primary "
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
