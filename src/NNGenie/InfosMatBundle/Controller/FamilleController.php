<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FamilleController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $familles = $em->getRepository('NNGenieInfosMatBundle:Famille')->myFindAll();
        return $this->render('NNGenieInfosMatBundle:Famille:index.html.twig', array(
                    'familles' => $familles
        ));
    }

    public function indexuserAction() {
        $em = $this->getDoctrine()->getManager();
        $familles = $em->getRepository('NNGenieInfosMatBundle:Famille')->myFindAll();
        return $this->render('NNGenieInfosMatBundle:FrontEnd:famille.html.twig', array(
                    'familles' => $familles
        ));
    }

    public function viewAction(\NNGenie\InfosMatBundle\Entity\Famille $famille) {
        return $this->render('NNGenieInfosMatBundle:Famille:view.html.twig', array(
                    'famille' => $famille
        ));
    }

    public function newAction(Request $request) {
        $famille = new \NNGenie\InfosMatBundle\Entity\Famille();
        $familleUnique = new \NNGenie\InfosMatBundle\Entity\Etat();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\FamilleType', $famille);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $familleUnique = $em->getRepository('NNGenieInfosMatBundle:Famille')->findOneBy(array("nom" => $famille->getNom(), "statut" => 1));
                if ($familleUnique == null) {
                    $em->getRepository('NNGenieInfosMatBundle:Famille')->saveFamille($famille);
                    $famille = new \NNGenie\InfosMatBundle\Entity\Famille();
                    $form = $this->createForm('NNGenie\InfosMatBundle\Form\FamilleType', $famille);
                    $message = $this->get('translator')->trans('Famille.created_success', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                } else {
                    $message = $this->get('translator')->trans('Famille.exist_already', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                }
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Famille.created_failure', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
            }
        }
        return $this->render('NNGenieInfosMatBundle:famille:new.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, \NNGenie\InfosMatBundle\Entity\Famille $famille) {
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\FamilleType', $famille);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $familleUnique = $em->getRepository('NNGenieInfosMatBundle:Famille')->findOneBy(array("nom" => $famille->getNom(), "statut" => 1));
                if ($familleUnique && $familleUnique->getId() != $famille->getId()) {
                    $message = $this->get('translator')->trans('Famille.exist_already', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                } else {
                    $em->getRepository('NNGenieInfosMatBundle:Famille')->updateFamille($famille);
                    $message = $this->get('translator')->trans('Famille.updated_success', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirectToRoute('nn_genie_infos_mat_famille_index');
                }
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Famille.updated_failure', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
            }
        }
        return $this->render('NNGenieInfosMatBundle:famille:edit.html.twig', array(
                    'form' => $form->createView(), 'id' => $famille->getId()
        ));
    }

    public function deleteAction(\NNGenie\InfosMatBundle\Entity\Famille $famille) {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:famille')->deleteFamille($famille);
            $message = $this->get('translator')->trans('Famille.deleted_success', array(), "NNGenieInfosMatBundle");
            $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
        } catch (Exception $ex) {
            $message = $this->get('translator')->trans('Famille.deleted_faillure', array(), "NNGenieInfosMatBundle");
            $this->get('ras_flash_alert.alert_reporter')->addError($message);
        }

        return $this->redirectToRoute('nn_genie_infos_mat_famille_index');
    }

}
