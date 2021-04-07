<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                "label"=>"Prenom",
                "disabled"=>true
            ])
            ->add('lastname',TextType::class,[
                "label"=>"Nom",
                "disabled"=>true
            ])
            ->add('phonenumber',TextType::class,[
                "label"=>"Numero de telephone",
                "disabled"=>true
            ])
            ->add('email',EmailType::class,[
                "label"=>"Adresse mail"
            ])
            ->add('roles', ChoiceType::class,[

                "choices"=>[
                    "utilisateur"=>"ROLE_USER",
                    "administrateur"=>"ROLE_ADMIN"
                ],
                "multiple"=> false

            ])
            ->add("submit",SubmitType::class,[
                "label"=> "modifier"
            ])
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
