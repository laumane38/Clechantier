<?php

namespace App\Form;

use App\Entity\OperationList;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationListAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class,[
            'label'=>'Nom : *',
            'row_attr' => [
                'class' => 'input'
            ],
            'attr'=>[
                'placeholder'=>'Nom'
            ]
        ])
        ->add('defaultPrice', TextType::class,[
            'label'=>'Prix par defaut :',
            'required'   => false,
            'row_attr' => [
                'class' => 'input'
            ],
            'attr'=>[
                'placeholder'=>'Prix par defaut'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OperationList::class
        ]);
    }
}
