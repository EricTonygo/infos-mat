<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClassematerielController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $classemateriels = $em->getRepository('NNGenieInfosMatBundle:Classemateriel')->myFindAll();
        return $this->render('NNGenieInfosMatBundle:Classemateriel:index.html.twig', array(
            'classemateriels' => $classemateriels
        ));
    }
    
    public function newAction(Request $request)
    {
        $classemateriel = new \NNGenie\InfosMatBundle\Entity\Classemateriel();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\ClassematerielType', $classemateriel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Classemateriel')->saveClassemateriel($classemateriel);
            return $this->redirectToRoute('nn_genie_infos_mat_classemateriel_view', array('id' => $classemateriel->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:Classemateriel:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function viewAction(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel)
    {      
        return $this->render('NNGenieInfosMatBundle:Classemateriel:view.html.twig', array(
            'classemateriel' => $classemateriel
        ));
    }

    public function editAction(Request $request, \NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel)
    {
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\ClassematerielType', $classemateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Classemateriel')->updateClassemateriel($classemateriel);
            return $this->redirectToRoute('nn_genie_infos_mat_classemateriel_view', array('id' => $classemateriel->getId()));
        }

        return $this->render('NNGenieInfosMatBundle:Classemateriel:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NNGenieInfosMatBundle:Classemateriel')->deleteClassemateriel($classemateriel);
            
        return $this->redirectToRoute('nn_genie_infos_mat_classemateriel_index');
    }

}
