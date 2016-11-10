<?php

namespace NNGenie\MaintenanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FournisseurpieceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse', new \NNGenie\InfosMatBundle\Form\AdresseType())
            ->add('types', CollectionType::class, array(
                'entry_type' => \NNGenie\InfosMatBundle\Form\TypeType::class,
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
            'data_class' => 'NNGenie\MaintenanceBundle\Entity\Fournisseurpiece'
        ));
    }
}
