<?php

namespace App\Form\Admin;

use App\Entity\Admin\BasePizza;

use App\Entity\Admin\Ingredient;
use App\Entity\Admin\Pizza;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                "label"=>"nom : "
            ])

            ->add('comment', null,[
                "label"=>'option pour (calzone)'
            ])

            ->add('price',null,[
                "label"=> "prix : "
            ])
            ->add("image",FileType::class,[
                "mapped"=> false,
                "required"=> false,
                
            ])

            ->add('isActive', null,[
                "label"=> "afficher ?"
            ])

            ->add('ingredients',EntityType::class,[
                "class"=>Ingredient::class,
                "choice_label"=>"name",
                "multiple"=> true,
                "required"=>false,
                "group_by"=> "category.name",
                "attr"=>["class"=> "col-12"],
                "label_attr"=>["class"=> "col-12"]



            ])

            ->add('basePizza',EntityType::class,[
                "class"=>BasePizza::class,
                "label"=>"choix de la base",
                "choice_label"=>"name",
                "required"=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,


        ]);
    }
}
