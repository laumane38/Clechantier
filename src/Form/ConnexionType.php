<?php

namespace App\Form;

use App\Entity\Membre;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Votre email :',
                'attr' => [
                    'placeholder' => 'Votre email'
                ]

            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'attr' => [
                    'placeholder' => 'Votre mot de passe'
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
