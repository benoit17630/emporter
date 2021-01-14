<?php

namespace App\Form\Admin;

use App\Entity\Admin\Category;
use App\Entity\Admin\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                "label"=>"nom :"
            ])
            ->add('isFirst', null,[
                "label"=> "en premier :"
            ])
            ->add('isLast', null,[
                'label'=> "en dernier :"
            ])
            ->add('category',EntityType::class,[
                "class"=>Category::class,
                "choice_label"=> 'name',
                "label"=> 'categorie :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
