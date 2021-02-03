<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo : *',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Pseudo'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe : *',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'id' => 'password'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email : *',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
