<?php

namespace App\Form\Admin;

use App\Entity\Expositaire;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('nom', TextType::class,[
                "label"=>"Nom du representant",
                "attr"=>[
                    "placeholder" => "Obligatoire*"
                ]
            ])
            ->add('prenom', TextType::class, [
                "label"=>"Prenom du representant",
                "attr"=>[
                    "placeholder" => "Obligatoire*"
                ]
            ])
            ->add('email', EmailType::class, [
                "label"=>"Email du representant",
                "attr"=>[
                    "placeholder" => "Obligatoire*"
                ]
            ])
            ->add('contact', TextType::class, [
                "label"=>"Vos numeros de telephone",
                "attr"=>[
                    "placeholder" => "Obligatoire*"
                ]
            ])
            ->add('structure', TextType::class, [
                "required" => false,
                "label" => "Nom de la struture(association, entreprise,...)",
                "attr"=>[
                    "placeholder" => "Facultatif"
                ]
            ])
            ->add('emailStructure', EmailType::class, [
                "required" => false,
                "label" => "Email de la structure(Association, entreprise...)",
                "attr"=>[
                    "placeholder" => "Facultatif"
                ]
            ])
            ->add('produits', TextareaType::class, [
                "label" => "Les produits que vous souhaitez exposés",
                "attr"=>[
                    "placeholder" => "Obligatoire*"
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
            'data_class' => Expositaire::class,
        ]);
    }
}
