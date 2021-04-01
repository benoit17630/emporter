<?php

namespace App\Form;

use App\Entity\Admin\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user= $options['user'];
        $builder
            ->add('submit',SubmitType::class,[
                'label'=> 'Valider ma commande',
                'attr'=>[
                    'class'=>'btn-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user'=>[],

        ]);
    }
}
