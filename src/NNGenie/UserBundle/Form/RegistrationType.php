<?php

namespace NNGenie\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('nom')
            ->add('file',null,array(
                'attr' => array('class'=>'inputfile')
            ))
           ->add('roles', 'choice', array(
                       'label' => 'Privileges',
                       'multiple' => true,
                       'expanded' => true,
                       'choices' => array(
                           'ROLE_SUPER_ADMIN' => 'Super Administrateur',
                           'ROLE_ADMIN' => 'Administrateur',
                           'ROLE_USER' => 'Simple utilisateur'
                   )
               )
           );
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NNGenie\UserBundle\Entity\User'
        ));
    }
    
     public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
