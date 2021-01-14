<?php

namespace App\Form\Admin;

use App\Entity\Admin\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,["label"=>"nom"])
            ->add('adress', null,["label"=> "adresse"])
            ->add('phoneNumber', null,["label"=>"numéro de telephone"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
