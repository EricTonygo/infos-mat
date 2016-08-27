<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DisponibiliteController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $disponibilites = $em->getRepository('NNGenieInfosMatBundle:Disponibilite')->myFindAll();
        return $this->render('NNGenieInfosMatBundle:Disponibilite:index.html.twig', array(
            'disponibilites'=>$disponibilites
        ));
    }
    
    public function viewAction(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite) {
        return $this->render('NNGenieInfosMatBundle:Disponibilite:view.html.twig', array(
            'disponibilite' => $disponibilite
        ));
    }

    public function newAction(Request $request)
    {
        $disponibilite = new \NNGenie\InfosMatBundle\Entity\Disponibilite();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\DisponibiliteType', $disponibilite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Disponibilite')->saveDisponibilite($disponibilite);
            return $this->redirectToRoute('nn_genie_infos_mat_disponibilite_view', array('id' => $disponibilite->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:Disponibilite:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request,\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite )
    {
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\DisponibiliteType', $disponibilite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Disponibilite')->updateDisponibilite($disponibilite);
            return $this->redirectToRoute('nn_genie_infos_mat_disponibilite_view', array('id' => $disponibilite->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:Disponibilite:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NNGenieInfosMatBundle:Disponibilite')->deleteDisponibilite($disponibilite);
            
        return $this->redirectToRoute('nn_genie_infos_mat_disponibilite_index');
    }

}
