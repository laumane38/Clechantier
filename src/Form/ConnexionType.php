<?php

namespace App\Form;

use App\Entity\Membre;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email :',
                'attr' => [
                    'placeholder' => 'Email'
                ],
                'row_attr' => [
                    'class' => 'input'
                ]

            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe :',
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ],
                'row_attr' => [
                    'class' => 'input'
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
