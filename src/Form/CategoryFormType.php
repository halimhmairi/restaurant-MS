<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

use Symfony\Component\Validator\Constraints\File;
class CategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,[
                "label" => "Name",
                "attr" => ["class"=>"form-control"]
            ])
            ->add('description',TextareaType::class,[
                "label" =>"Description",
                "attr" => ["class"=>"form-control"]
            ])
            ->add('image',FileType::class,[
                "attr" =>["class"=>"form-control"],
                "constraints" => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image'
                    ])
                ]
            ])
            ->add('Reset',ResetType::class,[
                "attr" => ["class"=>"btn btn-danger float-left"]
            ])
            ->add('Save',SubmitType::class,[
                "attr" => ["class"=>"btn btn-primary float-right"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
