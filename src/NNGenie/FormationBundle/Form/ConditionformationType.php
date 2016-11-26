<?php

namespace NNGenie\FormationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use NNGenie\FormationBundle\Repository\FormationRepository;

class ConditionformationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diplome')
            ->add('agelimite')
            ->add('origine')
            ->add('experience')
            ->add('formation','entity', array(
                'class' => 'NNGenieFormationBundle:Formation',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(FormationRepository $repo) {
                    return $repo->getFormationQueryBuilder();
                }
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NNGenie\FormationBundle\Entity\Conditionformation'
        ));
    }
}