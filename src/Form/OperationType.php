<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\OperationList;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class OperationType extends AbstractType
{

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface    $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        $this->user = $this->tokenStorage->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder,array $options)
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
                        ->orderBy('u.id', 'ASC')
                        ->andWhere('u.user = :user')
                        ->setParameter('user', $this->user)
                        ;
                },
                'choice_label' => 'name',
            ])
            ->add('User', EntityType::class, [
                'class' => User::class,     
                'label' => 'Associer colaborateur :',
                'choice_label' => 'pseudo',
                'expanded' => true,
                'multiple' => true,

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
