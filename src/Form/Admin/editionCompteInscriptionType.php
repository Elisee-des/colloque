<?php

namespace App\Form\Admin;

use App\Entity\Axe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
        ->add('roles', ChoiceType::class, [
            "choices" => [
                "Rôle Utilisateur" => "ROLE_USER",
                "Rôle Administrateur" => "ROLE_ADMIN",
            ],
            "attr" => [
                "class" => "form-control mb-3"
            ],
            // "expanded" => true,
            "multiple" => true,
            "label" => "Definir le role de cet utilisateur"
        ])
        
        ->add('axe', EntityType::class, [
            "attr" => [
                "class" => "form-control mb-3"
            ],
            "class" => Axe::class,
            "label" => "Choisissez votre axe",
            "choice_label" => "nom",
        ])
            ->add('resumeFile', FileType::class, [
                "required" => false,
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
                    