<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Procede;
use NNGenie\MaintenanceBundle\Form\ProcedeType;

/**
 * Procede controller.
 *
 */
class ProcedeController extends Controller {

    /**
     * @Route("/procedes")
     * @Template()
     */
    public function procedesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryProcede = $em->getRepository("NNGenieMaintenanceBundle:Procede");
        $procede = new Procede();
        $form = $this->createForm(new ProcedeType(), $procede);
        //selectionne les seuls procedes materiel actifs
        $procedes = $repositoryProcede->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Procedes:procedes.html.twig', array('procedes' => $procedes, 'form' => $form->createView()));
    }

    /**
     * Creates a new Procede entity.
     *
     * @Route("/new-procede")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $procede = new Procede();
        $procedeUnique = new Procede();
        $form = $this->createForm(new ProcedeType(), $procede);
        $form->handleRequest($request);
        $repositoryProcede = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Procede");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $procedeUnique = $repositoryProcede->findBy(array("intitule" => $procede->getIntitule(), "statut" => 1));
                if ($procedeUnique == null) {
                    try {
                        $repositoryProcede->saveProcede($procede);
                        $message = $this->get('translator')->trans('Procede.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $procede = new Procede();
                        $form = $this->createForm(new ProcedeType(), $procede);
                        return $this->render('NNGenieMaintenanceBundle:Procedes:form-add-procede.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Procede.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Procedes:form-add-procede.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Procede.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Procedes:form-add-procede.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Procedes:form-add-procede.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_procedess'));
        }
    }

    /**
     * Finds and displays a Procede entity.
     *
     * @Route("/show-procede/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Procede $procede) {
        $deleteForm = $this->createDeleteForm($procede);

        return $this->render('procede/show.html.twig', array(
                    'procede' => $procede,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Procede entity.
     *
     * @Route("/edit-procede/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Procede $procede) {
        // $deleteForm = $this->createDeleteForm($procede);
        $editForm = $this->createForm(new ProcedeType(), $procede);
        $editForm->handleRequest($request);
        $repositoryProcede = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Procede");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryProcede->updateProcede($procede);
                    $message = $this->get('translator')->trans('Procede.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_procedes'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Procede.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Procedes:form-update-procede.html.twig', array('form' => $editForm->createView(), 'idprocede' => $procede->getId()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Procedes:form-update-procede.html.twig', array('form' => $editForm->createView(), 'idprocede' => $procede->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_procedes'));
        }
    }

    /**
     * Deletes a Procede entity.
     *
     * @Route("/delete-procede/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Procede $procede) {
        $request = $this->get("request");
        $repositoryProcede = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Procede");
        if ($request->isMethod('GET')) {
            try {
                $repositoryProcede->deleteProcede($procede);
                $message = $this->get('translator')->trans('Procede.deleted_success', array(), "NNGenieMaintenanceBundle");
               $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_procedes'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Procede.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_procedes'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_procedes'));
        }
    }

}