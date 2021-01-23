<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Votre email :',
                'attr' => [
                    'placeholder' => 'Email'
                ]

            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ]

            ])
            ->add('nom', TextType::class, [
                'label' => 'Votre nom :',
                'attr' => [
                    'placeholder' => 'Nom'
                ]

            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom :',
                'attr' => [
                    'placeholder' => 'Prénom'
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
