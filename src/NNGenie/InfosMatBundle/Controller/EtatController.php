<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EtatController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $etats = $em->getRepository('NNGenieInfosMatBundle:Etat')->myFindAll();
        return $this->render('NNGenieInfosMatBundle:Etat:index.html.twig', array(
            'etats'=>$etats
        ));
    }

    public function viewAction(\NNGenie\InfosMatBundle\Entity\Etat $etat)
    {
        return $this->render('NNGenieInfosMatBundle:Etat:view.html.twig', array(
            'etat' => $etat
        ));
    }

    public function newAction(Request $request)
    {
        $etat = new \NNGenie\InfosMatBundle\Entity\Etat();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\EtatType', $etat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Etat')->saveEtat($etat);
            return $this->redirectToRoute('nn_genie_infos_mat_etat_view', array('id' => $etat->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:etat:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request,\NNGenie\InfosMatBundle\Entity\Etat $etat)
    {
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\EtatType', $etat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Etat')->updateEtat($etat);
            return $this->redirectToRoute('nn_genie_infos_mat_etat_view', array('id' => $etat->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:Etat:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction(\NNGenie\InfosMatBundle\Entity\Etat $etat)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NNGenieInfosMatBundle:Etat')->deleteEtat($etat);
            
        return $this->redirectToRoute('nn_genie_infos_mat_etat_index');
    }

}
