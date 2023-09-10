<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
 
class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                "attr" => ["class"=>"form-control"]
            ])
            ->add('price',NumberType::class,[
                "attr" => ["class" => "form-control"]
            ])
            ->add('description',TextareaType::class , [
                "attr" => ["class" => "form-control"]
            ])
            ->add('offre',null,[
                "attr"=>["class"=>"form-control"]
            ])
            ->add('image',FileType::class,[
                "attr"=>["class"=>"form-control"],
                "required" => false
            ])
            ->add('Category',EntityType::class,[
                "label" => "Category",
                'class' => Category::class,
                "attr"=>["class"=>"form-control"],
                'choice_label' => 'name',
            ])
            ->add('Save',SubmitType::class,[
                "attr" => ["class"=>"btn btn-primary float-right"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
