<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class UserInformationChangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                "label"=>"Mon email",

            ])

            ->add('firstname',TextType::class,[
                "label"=> "Mon prénom",

            ])

            ->add('lastname',TextType::class,[
                "label"=> "Mon nom",

            ])

            ->add('phonenumber',TextType::class,[
                "label"=>'Mon numero de telephone',
                "constraints"=>[
                    new Regex("/^((\+)33|0)[1-9](\d{2}){4}$/")
                ]
            ])

            ->add('submit',SubmitType::class,[
                'label'=>"Mettre a jour"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
