<?php

namespace NNGenie\InfosMatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use NNGenie\InfosMatBundle\Repository\GenreRepository;
use NNGenie\InfosMatBundle\Repository\EtatRepository;
use NNGenie\InfosMatBundle\Repository\TypeRepository;
use NNGenie\InfosMatBundle\Repository\ProprietaireRepository;
use NNGenie\InfosMatBundle\Repository\FournisseurRepository;

class DonneetechniquetypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valeur')
            ->add('donneetechnique','entity', array(
                'class' => 'NNGenieInfosMatBundle:Donneetechnique',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(DonneetechniqueRepository $repo) {
                    return $repo->getDonneetechniqueQueryBuilder();
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
            'data_class' => 'NNGenie\InfosMatBundle\Entity\Donneetechniquetype'
        ));
    }
}
