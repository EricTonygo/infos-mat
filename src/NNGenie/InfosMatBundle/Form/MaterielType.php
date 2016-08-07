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
            ->add('nom')
            ->add('chassis')
            ->add('prix')
            ->add('age')
            ->add('description')
            ->add('datecreation', 'datetime')
            ->add('datemodification', 'datetime')
            ->add('nbvues')
			->add('mainpath',null,array(
                'attr' => array('class'=>'inputfile')
            ))
            ->add('statut')
            ->add('etat')
            ->add('fournisseur')
            ->add('genre')
            ->add('localisation')
            ->add('proprietaire')
            ->add('type')
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
