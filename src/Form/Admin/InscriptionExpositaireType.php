<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionExpositaireType extends AbstractType
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
    ->add('structure', TextType::class, [
        "attr" => [
            "class" => "form-control mb-3"
        ]
    ])
    ->add('produits', TextareaType::class, [
        "attr" => [
            "class" => "form-control mb-3"
        ]
    ])
        ->add('Inscription', SubmitType::class, [
            "attr" => [
                "class" => "col-12 btn btn-primary w-100"
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
