<?php

namespace App\Form\Admin;

use App\Entity\User;
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

class EditionParticipantType extends AbstractType
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
        ->add('contact', TextType::class, [
            "attr" => [
                "class" => "form-control mb-3"
            ]
    ])
        
        ->add('imagePayementFile', FileType::class, [
            "required" => false,
            "mapped" => false,
            "label"=> "Entre une capture d'ecran de votre payement",
            "attr" => [
                "class" => "form-control"
            ],
            "constraints" => [
                new File([
                    "maxSize" => "2M",
                    "mimeTypes" =>[
                        "image/jpeg",
                        "image/png",
                        "image/bmp",
                        "image/pjpeg",
                        "image/x-jps"
                    ]
                ])
            ]
        ])
        ->add('Edition', SubmitType::class, [
            "attr" => [
                "class" => " btn btn-primary"
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
