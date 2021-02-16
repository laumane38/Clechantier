<?php

namespace App\Form;

use App\Entity\Currency;
use App\Entity\OptionList;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OptionListAddType extends AbstractType
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
        ->add('currency', EntityType::class, [
            'class' => Currency::class,
            'row_attr' => [
                'class' => 'input'
            ],            
            'label' => 'Devise :',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'ASC');
            },
            'choice_label' => 'name',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OptionList::class
        ]);
    }
}
