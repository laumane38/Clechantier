<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Heading;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ArticleType extends AbstractType
{

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
            'label'=>'Marque: *',
            'row_attr' => [
                'class' => 'input'
            ],
            'attr'=>[
                'placeholder'=>'Marque'
            ]
        ])
        ->add('model', TextType::class,[
            'label'=>'Model: *',
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
            ->add('description', TextareaType::class,[
                'label'=>'Description :',
                'row_attr' => [
                    'class' => 'input'
                ],
                'attr'=>[
                    'placeholder'=>'Description'
                ],
                'required' => false,
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
