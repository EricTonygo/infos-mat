<?php

namespace NNGenie\MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PropreteType extends AbstractType
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
            ->add('typeproprete','entity', array(
                'class' => 'NNGenieMaintenanceBundle:Typeproprete',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(\NNGenie\MaintenanceBundle\Repository\TypepropreteRepository $repo) {
                    return $repo->getTypepropreteQueryBuilder();
                }
            ))
            ->add('operations', CollectionType::class, array(
                'entry_type' => OperationType::class,
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
            'data_class' => 'NNGenie\MaintenanceBundle\Entity\Proprete'
        ));
    }
}
