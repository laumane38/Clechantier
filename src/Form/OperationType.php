<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\OperationList;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', DateType::class, [
                'label' => 'Date de début : *',
                'widget' => 'single_text',
                'html5' => false,
                'row_attr' => [
                    'class' => 'input',
                ], 
                'attr' => [
                    'class' => 'js-datepickerStart'
                ],
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Date de fin : *',
                'widget' => 'single_text',
                'html5' => false,
                'row_attr' => [
                    'class' => 'input',
                ], 
                'attr' => [
                    'class' => 'js-datepickerEnd'
                ],
            ])
            ->add('operationList', EntityType::class, [
                'class' => OperationList::class,
                'row_attr' => [
                    'class' => 'input',
                ],            
                'label' => 'Choix des opérations : *',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
