<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FamilleController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $familles = $em->getRepository('NNGenieInfosMatBundle:Famille')->myFindAll();
        return $this->render('NNGenieInfosMatBundle:Famille:index.html.twig', array(
            'familles' => $familles
        ));
    }

    public function viewAction(\NNGenie\InfosMatBundle\Entity\Famille $famille)
    {
        return $this->render('NNGenieInfosMatBundle:Famille:view.html.twig', array(
            'famille' => $famille
        ));
    }

    public function newAction(Request $request)
    {
       $famille = new \NNGenie\InfosMatBundle\Entity\Famille();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\FamilleType', $famille);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Famille')->saveFamille($famille);
            return $this->redirectToRoute('nn_genie_infos_mat_famille_index');
        }
        return $this->render('NNGenieInfosMatBundle:famille:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, \NNGenie\InfosMatBundle\Entity\Famille $famille)
    {
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\FamilleType', $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Famille')->updateFamille($famille);
            return $this->redirectToRoute('nn_genie_infos_mat_famille_index');
        }

        return $this->render('NNGenieInfosMatBundle:famille:edit.html.twig', array(
            'form' => $form->createView(),'id' => $famille->getId()
        ));
    }

    public function deleteAction(\NNGenie\InfosMatBundle\Entity\Famille $famille)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NNGenieInfosMatBundle:famille')->deleteFamille($famille);
            
        return $this->redirectToRoute('nn_genie_infos_mat_famille_index');
    }

}
