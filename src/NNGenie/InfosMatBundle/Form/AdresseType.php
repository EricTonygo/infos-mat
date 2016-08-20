<?php

namespace NNGenie\InfosMatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville','text')
            ->add('tel','text')
            ->add('boitepostale','text')
            ->add('pays','country')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NNGenie\InfosMatBundle\Entity\Adresse',
            'csrf_protection' => true,
           'csrf_field_name' => '_token',
          // a unique key to help generate the secret token
          'intention'       => 'task_item_intention',
        ));
    }
}
