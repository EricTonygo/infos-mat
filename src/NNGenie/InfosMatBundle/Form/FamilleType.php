<?php

namespace NNGenie\InfosMatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use NNGenie\InfosMatBundle\Repository\ClassematerielRepository;

class FamilleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom','text')
            ->add('code','text')
            ->add('classemateriel','entity',array(
                'class'=>'NNGenieInfosMatBundle:Classemateriel',
                'property'=>'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(ClassematerielRepository $repo) {
                                return $repo->getCMaterielQueryBuilder();
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
            'data_class' => 'NNGenie\InfosMatBundle\Entity\Famille'
        ));
    }
}
