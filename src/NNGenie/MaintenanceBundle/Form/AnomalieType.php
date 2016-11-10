<?php

namespace NNGenie\MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnomalieType extends AbstractType
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
            ->add('disfonconstates')
            ->add('causeseventuelles')
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
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NNGenie\MaintenanceBundle\Entity\Anomalie'
        ));
    }
}
