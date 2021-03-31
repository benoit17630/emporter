<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                "label"=>"Mon email",
                'disabled'=>true
            ])
            ->add('firstname',TextType::class,[
                "label"=> "Mon prénom",
                "disabled"=> true
            ])
            ->add('lastname',TextType::class,[
                "label"=> "Mon nom",
                "disabled"=>true
            ])

            ->add('password',PasswordType::class,[
                'label'=> "Mon mot de passe actuel",
                'mapped'=> false,
                'attr'=>[
                    'placeholder'=> " saisir votre mot de passe actuel"
                ]
            ])
            ->add('new_password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'mapped'=> false,
                'invalid_message'=> 'le mot de passe et la confirmation doivent etre identique',
                'required'=>true,
                'first_options'=>[
                    'label'=> 'Mon nouveau mot de passe :',
                    'attr'=>[
                        'placeholder'=>'Merci de saisir votre nouveau mot de passe'
                    ],
                ],
                'second_options'=>[
                    'label'=>'Confirmer votre nouveau mot de passe :',
                    'attr'=>[
                        'placeholder'=>'Merci de confirmer votre nouveau mot de passe'
                    ],
                ],
                'constraints'=>[
                    new Length(null, 4, 30),
                    new  NotBlank()
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
