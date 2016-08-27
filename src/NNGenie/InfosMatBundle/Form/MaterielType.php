<?php

namespace NNGenie\InfosMatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chassis')
            ->add('prix')
            ->add('age')
            ->add('description')
            ->add('datecreation', 'date')
            ->add('datemodification', 'date')
            ->add('mainpath',null,array(
                'attr' => array('class'=>'inputfile')
            ))
            ->add('etat','entity', array(
                'class' => 'NNGenieInfosMatBundle:Etat',
                'property' => 'nom',
                'empty_value' => "Etat du materiel",
                
            ))
            ->add('fournisseur','entity', array(
                'class' => 'NNGenieInfosMatBundle:Fournisseur',
                'property' => 'nom',
                'empty_value' => "Choisissez le fournisseur",
            ))
            ->add('genre','entity', array(
                'class' => 'NNGenieInfosMatBundle:Genre',
                'property' => 'nom',
                'empty_value' => "Choisissez le genre",
            ))
            ->add('localisation',new LocalisationType())
            ->add('proprietaire','entity', array(
                'class' => 'NNGenieInfosMatBundle:Proprietaire',
                'property' => 'nom',
                'empty_value' => "Choisissez le proprietaire",
            ))
            ->add('type','entity', array(
                'class' => 'NNGenieInfosMatBundle:Type',
                'property' => 'nom',
                'empty_value' => "Choisissez le type",
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NNGenie\InfosMatBundle\Entity\Materiel'
        ));
    }
}
