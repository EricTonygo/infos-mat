<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Panne;
use NNGenie\MaintenanceBundle\Form\PanneType;

/**
 * Panne controller.
 *
 */
class PanneController extends Controller {

    /**
     * @Route("/pannes")
     * @Template()
     */
    public function pannesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryPanne = $em->getRepository("NNGenieMaintenanceBundle:Panne");
        $panne = new Panne();
        $form = $this->createForm(new PanneType(), $panne);
        //selectionne les seuls pannes materiel actifs
        $pannes = $repositoryPanne->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Pannes:pannes.html.twig', array('pannes' => $pannes, 'form' => $form->createView()));
    }
    
    /**
     * @Route("/pannes-user")
     * @Template()
     */
    public function pannesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryPanne = $em->getRepository("NNGenieMaintenanceBundle:Panne");
        $panne = new Panne();
        $form = $this->createForm(new PanneType(), $panne);
        $display_tab = 1;
        //selectionne les seuls pannes materiel actifs
        $pannes = $repositoryPanne->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:panne.html.twig', array('pannes' => $pannes, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Panne entity.
     *
     * @Route("/new-panne")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $panne = new Panne();
        $panneUnique = new Panne();
        $form = $this->createForm(new PanneType(), $panne);
        $form->handleRequest($request);
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $panneUnique = $repositoryPanne->findBy(array("nom" => $panne->getNom(), "statut" => 1));
                if ($panneUnique == null) {
                    try {
                        $repositoryPanne->savePanne($panne);
                        $message = $this->get('translator')->trans('Panne.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $panne = new Panne();
                        $form = $this->createForm(new PanneType(), $panne);
                        return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Panne.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Panne.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Pannes:form-add-panne.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_pannes'));
        }
    }

    /**
     * Finds and displays a Panne entity.
     *
     * @Route("/show-panne/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Panne $panne) {
        $deleteForm = $this->createDeleteForm($panne);

        return $this->render('panne/show.html.twig', array(
                    'panne' => $panne,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Panne entity.
     *
     * @Route("/edit-panne/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Panne $panne) {
        // $deleteForm = $this->createDeleteForm($panne);
        $editForm = $this->createForm(new PanneType(), $panne);
        $editForm->handleRequest($request);
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryPanne->updatePanne($panne);
                    $message = $this->get('translator')->trans('Panne.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_panne'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Panne.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Pannes:form-update-panne.html.twig', array('form' => $editForm->createView(), 'idpanne' => $panne->getId()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Pannes:form-update-panne.html.twig', array('form' => $editForm->createView(), 'idpanne' => $panne->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_panne'));
        }
    }

    /**
     * Deletes a Panne entity.
     *
     * @Route("/delete-panne/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Panne $panne) {
        $request = $this->get("request");
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");
        if ($request->isMethod('GET')) {
            try {
                $repositoryPanne->deletePanne($panne);
                $message = $this->get('translator')->trans('Panne.deleted_success', array(), "NNGenieMaintenanceBundle");
               $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_panne'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Panne.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_panne'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_panne'));
        }
    }

}