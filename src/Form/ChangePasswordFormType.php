<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                'first_options' => ["row_attr"=>["class"=>"my-2"],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'rentrer un mot de passe ',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'votre mot de passe doit contenir{{ limit }} caracters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'nouveau mot de passe',
                ],
                'second_options' => [
                    "row_attr"=>["class"=>"my-2"],
                    'label' => 'repeter le mot de passe',
                ],
                'invalid_message' => 'le mot de passe doit etre identique',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
