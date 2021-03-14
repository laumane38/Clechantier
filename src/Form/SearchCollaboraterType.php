<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchCollaboraterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'required' => false,
                'label' => 'Pseudo : ',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Pseudo',
                ]
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => 'Email : ',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Email',
                ]
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'Nom : ',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Nom',
                ]
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'Prénom : ',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Prénom',
                ]
            ])
            ->add('companie', TextType::class, [
                'required' => false,
                'label' => 'Entreprise : ',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Entreprise',
                ]
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
