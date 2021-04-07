<?php

namespace App\Form;

use App\Entity\Admin\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("wantedAt",TimeType::class,[
                "label"=>"A quelle heure desirer vous votre pizza ?",
                'placeholder' => [
                    'hour' => 'heure', 'minute' => 'Minute'
                ],
                "hours"=>[
                    "11",
                    "12",
                    "13",
                    "18",
                    "19",
                    "20",
                ],
                "minutes"=>[
                    "00",
                    "15",
                    "30",
                    "45"
                ]



            ])
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
            "data_class"=>Order::class,


        ]);
    }
}
