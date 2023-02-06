<?php

namespace App\Form\Admin;

use App\Entity\Axe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class editionCompteInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            "attr" => [
                "class" => "form-control mb-3"
            ]
    ])
    ->add('prenom', TextType::class, [
            "attr" => [
                "class" => "form-control mb-3"
            ]
    ])
        ->add('email', EmailType::class, [
            "attr" => [
                "class" => "form-control mb-3"
            ]
        ])
        
        ->add('axe', EntityType::class, [
            "attr" => [
                "class" => "form-control mb-3"
            ],
            "class" => Axe::class,
            "label" => "Choisissez votre axe",
            "choice_label" => "nom",
        ])
            ->add('Editer', SubmitType::class, [
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
