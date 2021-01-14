<?php

namespace App\Form\Admin;

use App\Entity\Admin\OpeningTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpeningTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,[
                "label"=> "de a ? :"
            ])
            ->add('isActive', null,[
                "label"=> "afficher ? :"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OpeningTime::class,
        ]);
    }
}
