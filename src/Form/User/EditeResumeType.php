<?php

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditeResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('resumeFile', FileType::class, [
            "mapped" => false,
            "label"=> "Entrer votre resumer",
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
        ->add("Modifier", SubmitType::class , [
            "attr" => [
                "class" => "btn btn-outline-primary mb-3"
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
