<?php

namespace App\Form;

use App\Entity\Gallery;
use App\Entity\Menu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('images', FileType::class, [
                "attr" => [
                    "class" => "form-control",
                    "multiple" => "multiple",
                    "accept" => "image/*",
                ],
                "multiple" => true,
                "required" => false,
            ])
            ->add('image', EntityType::class, [
                "label" => "Menus",
                "class" => Menu::class,
                "attr" => ["class" => "form-control"],
                "choice_label" => 'name',
            ])
            ->add('save', SubmitType::class, [
                "label" => "Save",
                "attr" => ["class" => "btn btn-primary float-right"]
            ])
            ->add('reset', ResetType::class, [
                "label" => "Reset",
                "attr" => ["class" => "btn btn-danger float-left"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}