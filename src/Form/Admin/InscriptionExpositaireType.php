<?php

namespace App\Form\Admin;

use App\Entity\Expositaire;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionExpositaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('structure', TextType::class)
            ->add('emailStructure', EmailType::class, [
                "label" => "Email de la structure(Association, entreprise...)"
            ])
            ->add('produits', CKEditorType::class, [
                "label" => "Les produits que vous souhaitez exposés"
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
            'data_class' => Expositaire::class,
        ]);
    }
}
