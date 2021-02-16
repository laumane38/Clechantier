<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\OptionList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionCheckboxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('optionList' , EntityType::class , [
            'class' => OptionList::class,
            'expanded' => true,
            'multiple' => true,
            'data_class' => null
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Option::class,
        ]);
    }
}
