<?php

namespace NNGenie\MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class OperationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('procede','entity', array(
                'class' => 'NNGenieMaintenanceBundle:Procede',
                'property' => 'intitule',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(\NNGenie\MaintenanceBundle\Repository\ProcedeRepository $repo) {
                    return $repo->getProcedeQueryBuilder();
                }
            ))
            ->add('produits', CollectionType::class, array(
                'entry_type' => ProduitType::class,
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
            'data_class' => 'NNGenie\MaintenanceBundle\Entity\Operation'
        ));
    }
}
