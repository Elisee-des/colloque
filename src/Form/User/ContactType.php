<?php

namespace App\Form\User;

use App\Entity\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('nom', TextType::class, [
            //     "attr" => ["class" => "form-control mb-3"]
            // ])
            // ->add('email', EmailType::class, [
            //     "attr" => ["class" => "form-control mb-3"]
            // ])
            ->add('sujet', TextType::class, [
                "attr" => ["class" => "form-control mb-3"]
            ])
            ->add('message', TextareaType::class, [
                "attr" => ["class" => "form-control mb-3"]
            ])
            ->add('Envoyez', SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-outline-primary mb-3"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Email::class,
        ]);
    }
}
