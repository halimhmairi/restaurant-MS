<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\DateType;
class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity',null,[
                "attr" => ["class"=>"form-control"]
            ])
            ->add('total_price',null,[
                "attr" => ["class"=>"form-control"]
            ])
            ->add('delivery_date',null,[
                "attr" => ["class"=>"form-control"],
                 'widget' => 'choice',
                 'input'  => 'datetime_immutable'
            ])
            ->add('state',null,[
                "attr"=> ["class"=>"form-control"]
            ])
          //  ->add('menu_id')
            ->add("Save",SubmitType::class,[
                "attr" => ["class"=>"btn btn-primary float-right"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
