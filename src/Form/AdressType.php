<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class AdressType extends AbstractType
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
            ->add('adressTitle', TextType::class,[
                'label'=>'Titre de l\'adresse : *',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Ex : Livraison'
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
            ->add('firstName',TextType::class,[
                'label'=> 'Nom :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Nom',
                    'value' => $user->getFirstName()
                ]
            ])
            ->add('lastName', TextType::class,[
                'label'=> 'Prénom :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Prénom',
                    'value' => $user->getLastName()
                ]
            ])
            ->add('companie', TextType::class,[
                'label'=> 'Entreprise :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Entreprise'
                ]
            ])
            ->add('adress', TextType::class,[
                'label'=> 'Adresse :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Adresse'
                ]
            ])
            ->add('adress2', TextType::class,[
                'label'=> 'Adresse (suite) :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'suite d\'adresse si nécéssaire'
                ]
            ])
            ->add('zipCode', IntegerType::class,[
                'label'=> 'Code postal :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Code postal'
                ]
            ])
            ->add('appartmentNumber', TextType::class,[
                'label'=> 'N° d\'appartement :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Numéro d\'appartement'
                ]
            ])
            ->add('floor', TextType::class,[
                'label'=> 'Etage :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Etage'
                ]
            ])
            ->add('city', TextType::class,[
                'label'=> 'Ville :',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Ville'
                ]
            ])
            ->add('country', TextType::class,[
                'label'=> 'Pays',
                'required'   => false,
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Pays'
                ]
            ])
            ->add('defaultAdress', CheckboxType::class,[
                'label'=> 'Définir par défaut',
                'required'   => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
