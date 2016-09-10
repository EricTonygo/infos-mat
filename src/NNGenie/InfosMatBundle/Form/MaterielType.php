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
            //->add('datecreation', 'date')
            //->add('datemodification', 'date')
            ->add('file',null,array(
                'attr' => array('class'=>'inputfile')
            ))
            ->add('etat','entity', array(
                'class' => 'NNGenieInfosMatBundle:Etat',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(EtatRepository $repo) {
                    return $repo->getEtatQueryBuilder();
                }
            ))
            ->add('fournisseur','entity', array(
                'class' => 'NNGenieInfosMatBundle:Fournisseur',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(FournisseurRepository $repo) {
                    return $repo->getFournisseurQueryBuilder();
                }
            ))
            ->add('genre','entity', array(
                'class' => 'NNGenieInfosMatBundle:Genre',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(GenreRepository $repo) {
                    return $repo->getGenreQueryBuilder();
                }
            ))
            ->add('localisation',new LocalisationType())
            ->add('proprietaire','entity', array(
                'class' => 'NNGenieInfosMatBundle:Proprietaire',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(ProprietaireRepository $repo) {
                    return $repo->getProprietaireQueryBuilder();
                }
            ))
            ->add('type','entity', array(
                'class' => 'NNGenieInfosMatBundle:Type',
                'property' => 'nom',
                'empty_value' => "",
                'multiple'=>false,
                'query_builder' => function(TypeRepository $repo) {
                    return $repo->getTypeQueryBuilder();
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
            'data_class' => 'NNGenie\InfosMatBundle\Entity\Materiel'
        ));
    }
}
