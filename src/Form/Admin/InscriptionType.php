<?php

namespace App\Form\Admin;

use App\Entity\Axe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                "mapped" => true,
                "type" => PasswordType::class,
                "first_options" => [
                    "label" => "Nouveau mot de passe",
                    'attr' => ['autocomplete' => 'new-password']
                ],
                "second_options" => [
                    "label" => "Repeter le mot de passe ",
                    'attr' => ['autocomplete' => 'new-password']
                ],
                "invalid_message" => "Mot de passe non identique",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add('axe', EntityType::class, [
                "class" => Axe::class,
                "label" => "Choisissez votre axe"
            ])
            ->add('communication', FileType::class, [
                "label"=> "Votre communication",
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "mimeTypes" =>[
                            "image/jpeg",
                            "image/png"
                        ]
                    ])
                ]
            ])
            ->add('resume', FileType::class, [
                "label"=> "Votre resumer de communication",
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "mimeTypes" =>[
                            "image/jpeg",
                            "image/png"
                        ]
                    ])
                ]
            ])
            ->add('imagePayement', FileType::class, [
                "label"=> "Entre une capture d'ecran de votre payement",
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "mimeTypes" =>[
                            "image/jpeg",
                            "image/png"
                        ]
                    ])
                ]
            ])
            ->add('Inscription', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
