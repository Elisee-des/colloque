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
            ->add('axe', EntityType::class, [
                "attr" => [
                    "class" => "form-control mb-3"
                ],
                "class" => Axe::class,
                "label" => "Choisissez votre axe",
                "choice_label" => "nom",
            ])
            ->add('communicationFile', FileType::class, [
                "mapped" => false,
                "label"=> "Votre communication",
                "attr" => [
                    "class" => "form-control"
                ],
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "mimeTypes" =>[
                            "application/pdf",
                            "application/msword",
                            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                            "application/vnd.ms-word.document.macroEnabled.12"
                        ]
                    ])
                ]
            ])
            ->add('resumeFile', FileType::class, [
                "mapped" => false,
                "label"=> "Votre resumer de communication",
                "attr" => [
                    "class" => "form-control"
                ],
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "mimeTypes" =>[
                            "application/pdf",
                            "application/msword",
                            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                            "application/vnd.ms-word.document.macroEnabled.12"
                        ]
                    ])
                ]
            ])
            ->add('imagePayementFile', FileType::class, [
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
