<?php

namespace App\Form\User;

use App\Entity\Axe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditerAxeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('axe', EntityType::class, [
                "class" => Axe::class,
                "label" => "Choisissez a nouveau votre axe",
                "attr" =>  ["class" => "form-control mb-3"],
                "choice_label" => "nom"
            ]
            )
            ->add('Modifier', SubmitType::class,  [
                "attr" => [
                    "class" => "btn btn-outline-primary mb-3"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
