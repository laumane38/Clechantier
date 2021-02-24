<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Heading;
use App\Entity\Currency;
use App\Entity\RentalType;
use App\Entity\OptionList;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ArticleType extends AbstractType
{

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface    $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->user = $this->tokenStorage->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
        ->add('heading', EntityType::class, [
            'class' => Heading::class,
            'row_attr' => [
                'class' => 'input'
            ],            
            'label' => 'Rubrique',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'ASC');
            },
            'choice_label' => 'name',
        ])
        ->add('brand', TextType::class,[
            'label'=>'Marque : *',
            'row_attr' => [
                'class' => 'input'
            ],
            'attr'=>[
                'placeholder'=>'Marque'
            ]
        ])
        ->add('model', TextType::class,[
            'label'=>'Model : *',
            'row_attr' => [
                'class' => 'input'
            ],
            'attr'=>[
                'placeholder'=>'Model'
            ]
        ])
            ->add('serial', TextType::class,[
                'label'=>'Numéro de série :',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Numéro de série'
                ],
                'required' => false,
            ])
            ->add('year', TextType::class,[
                'label'=>'Année de fabrication :',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Année de fabrication'
                ],
                'required' => false,
            ])
            ->add('location', TextType::class,[
                'label'=>'Localisation :',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Localisation'
                ],
                'required' => false,
            ])
            ->add('color', TextType::class,[
                'label'=>'Couleur :',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Couleur'
                ],
                'required' => false,
            ])
            ->add('rentalType', EntityType::class, [
                'class' => RentalType::class,
                'row_attr' => [
                    'class' => 'input'
                ],            
                'label' => 'Type de location :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('price', TextType::class,[
                'label'=>'Prix pour la période :',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Prix pour la période'
                ],
                'required' => false,
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
            ->add('imageMain', FileType::class,[
                'label'=>'Image principale : *',
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Merci de bien vouloir télécharger une image valide',
                    ])
                ],
                'data_class' => null
            ])
            ->add('description', TextareaType::class,[
                'label'=>'Description :',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder' => 'Description',
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('OptionList', EntityType::class, [
                'class' => OptionList::class,     
                'label' => 'Options :',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC')
                        ->andWhere('u.user = :user')
                        ->setParameter('user', $this->user)
                        ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}