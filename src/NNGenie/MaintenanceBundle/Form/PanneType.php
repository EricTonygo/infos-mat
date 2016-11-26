<?php

namespace NNGenie\MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PanneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('type','entity', array(
                'class' => 'NNGenieInfosMatBundle:Type',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(\NNGenie\InfosMatBundle\Repository\TypeRepository $repo) {
                    return $repo->getTypeQueryBuilder();
                }
            ))
            ->add('actions')
            ->add('causeseventuelles')
            ->add('pieces', CollectionType::class, array(
                'entry_type' => PieceType::class,
                'allow_add' => true,
                'by_reference' =>false,
                'allow_delete' =>true
            ))
            ->add('operations', CollectionType::class, array(
                'entry_type' => OperationType::class,
                'allow_add' => true,
                'by_reference' =>false,
                'allow_delete' =>true
            ))
             ->add('tests', CollectionType::class, array(
                'entry_type' => TestType::class,
                'allow_add' => true,
                'by_reference' =>false,
                'allow_delete' =>true
            ))
            ->add('questions', CollectionType::class, array(
                'entry_type' => QuestionType::class,
                'allow_add' => true,
                'by_reference' =>false,
                'allow_delete' =>true
            ))
            //->add('operations')
           // ->add('tests')
            //->add('questions')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NNGenie\MaintenanceBundle\Entity\Panne'
        ));
    }
}