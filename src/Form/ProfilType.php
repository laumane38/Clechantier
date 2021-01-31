<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfilType extends AbstractType
{

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface    $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();


        $builder
        ->add('email', EmailType::class, [
            'label' => 'Email : *',
            'row_attr' => [
                'class' => 'input'
            ],
            'attr' => [
                'placeholder' => 'Email',
                'value' => $user->getEmail()
            ]
        ])
        ->add('firstName', TextType::class, [
            'label' => 'Nom : *',
            'row_attr' => [
                'class' => 'input'
            ],
            'attr' => [
                'placeholder' => 'Nom',
                'value' => $user->getFirstName()
            ]
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Prénom : *',
            'row_attr' => [
                'class' => 'input'
            ],
            'attr' => [
                'placeholder' => 'Prénom',
                'value' => $user->getLastName()
            ]
        ])
        ->add('gender', ChoiceType::class,[
            'label'=>'Genre',
            'required'   => false,
            'row_attr' => [
                'class' => 'input'
            ],
            'choices'=>[
                'M'=>'M',
                'Mme'=>'Mme',
                'Mlle'=>'Mlle'
            ],
            'choice_attr' =>[
                $user->getGender()=> ['selected' => 'is_selected']
            ]
        ])
        ->add('companie', TextType::class,[
            'label'=> 'Entreprise :',
            'required'   => false,
            'row_attr' => [
                'class' => 'input'
            ],
            'attr'=>[
                'placeholder'=>'Entreprise',
                'value' => $user->getCompanie()
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
