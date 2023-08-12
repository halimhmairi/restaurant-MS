<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,[
                "label" => "Name",
                "attr" => ["class"=>"form-control"]
            ])
            ->add('description',TextareaType::class,[
                "label"=>"Description",
                "attr"=>["class"=>"form-control"]
            ])
            ->add('price',null,[
                "label"=>"Price",
                "attr"=>["class"=>"form-control"]
            ])
            ->add('promotion',null,[
                "label"=>"Promotion",
                "attr"=>["class"=>"form-control"]
            ])
            ->add('image',FileType::class,[
                "label"=>"Image",
                "attr"=>["class"=>"form-control"]
            ])
            ->add('created_at')
            ->add('category')
            ->add('Reset',ResetType::class,[
                "attr" => ["class"=>"btn btn-danger float-left"]
            ])
            ->add('Submit',SubmitType::class,[
                "attr" => ["class"=>"btn btn-primary float-right"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
