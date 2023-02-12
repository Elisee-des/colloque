<?php

namespace App\Form\Admin;

use App\Entity\Email;
use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminEnvoyeMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', EntityType::class, [
                "class" => User::class,
                "label" => "Veuillez choisir la personne a qui vous voulez envoyez un email",
                "attr" => ["class" => "form-control mb-3"]
            ])
            ->add('sujet', TextType::class,[
                "attr" => [
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('message', CKEditorType::class, [
                "attr" => [
                    "class" => "form-control mb-3"
                ]
            ])
            ->add('Envoyez', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Email::class,
        ]);
    }
}
