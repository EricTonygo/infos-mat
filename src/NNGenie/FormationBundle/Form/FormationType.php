<?php

namespace NNGenie\FormationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use NNGenie\FormationBundle\Repository\FormeformationRepository;
use NNGenie\FormationBundle\Repository\TypeformationRepository;
use NNGenie\FormationBundle\Repository\CentreformationRepository;
use NNGenie\FormationBundle\Repository\ResponsableformationRepository;

class FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('date', 'datetime')
            ->add('cible')
            ->add('objectifprincip')
            ->add('objectifsecond')
            ->add('formeformation','entity', array(
                'class' => 'NNGenieFormationBundle:Formeformation',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(FormeformationRepository $repo) {
                    return $repo->getFormeformationQueryBuilder();
                }
            ))
            ->add('centreformation','entity', array(
                'class' => 'NNGenieFormationBundle:Centreformation',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(CentreformationRepository $repo) {
                    return $repo->getCentreformationQueryBuilder();
                }
            ))
            ->add('typeformation','entity', array(
                'class' => 'NNGenieFormationBundle:Typeformation',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(TypeformationRepository $repo) {
                    return $repo->getTypeformationQueryBuilder();
                }
            ))
            ->add('idresponsable','entity', array(
                'class' => 'NNGenieFormationBundle:Responsableformation',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>true,
                'query_builder' => function(ResponsableformationRepository $repo) {
                    return $repo->getResponsableformationQueryBuilder();
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
            'data_class' => 'NNGenie\FormationBundle\Entity\Formation'
        ));
    }
}
