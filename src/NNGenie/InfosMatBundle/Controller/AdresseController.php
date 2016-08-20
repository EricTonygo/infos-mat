<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdresseController extends Controller
{
    public function indexAction()
    {
        
    }

    public function viewAction(\NNGenie\InfosMatBundle\Entity\Adresse $adresse)
    {
        return $this->render('NNGenieInfosMatBundle:Adresse:view.html.twig', array(
            'adresse' => $adresse
        ));
    }

    public function newAction(Request $request)
    {
        $adresse = new \NNGenie\InfosMatBundle\Entity\Adresse();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\AdresseType', $adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Adresse')->saveAdresse($adresse);
            return $this->redirectToRoute('nn_genie_infos_mat_adresse_view', array('id' => $adresse->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:Adresse:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, \NNGenie\InfosMatBundle\Entity\Adresse $adresse)
    {
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\AdresseType', $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Adresse')->updateAdresse($adresse);
            return $this->redirectToRoute('nn_genie_infos_mat_adresse_view', array('id' => $adresse->getId()));
        }

        return $this->render('NNGenieInfosMatBundle:Adresse:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction(\NNGenie\InfosMatBundle\Entity\Adresse $adresse)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NNGenieInfosMatBundle:Adresse')->deleteAdresse($adresse);
            
        return $this->redirectToRoute('nn_genie_infos_mat_adresse_index');
    }

}
