<?php

namespace App\Form\Admin;

use App\Entity\Admin\Order;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>"email",
                "disabled"=> true,

            ])

             ->add('orderNumber',TextType::class,[
               "label"=> "Numero de commande",
             "disabled"=> true
           ])
            ->add('state',ChoiceType::class,[
                "choices"=>[
                    "Non payé"=>0,
                    "Payer"=>1,
                    "En preparation"=>2,
                    "Prete"=>3,
                    "Terminer"=>4
                ],
                "multiple"=>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
