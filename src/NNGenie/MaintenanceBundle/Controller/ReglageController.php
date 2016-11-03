<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Reglage;
use NNGenie\MaintenanceBundle\Form\ReglageType;

/**
 * Reglage controller.
 *
 */
class ReglageController extends Controller {

    /**
     * @Route("/reglages")
     * @Template()
     */
    public function reglagesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryReglage = $em->getRepository("NNGenieMaintenanceBundle:Reglage");
        $reglage = new Reglage();
        $form = $this->createForm(new ReglageType(), $reglage);
        //selectionne les seuls reglages materiel actifs
        $reglages = $repositoryReglage->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Reglages:reglages.html.twig', array('reglages' => $reglages, 'form' => $form->createView()));
    }

    /**
     * @Route("/reglages-user")
     * @Template()
     */
    public function reglagesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryReglage = $em->getRepository("NNGenieMaintenanceBundle:Reglage");
        $reglage = new Reglage();
        $form = $this->createForm(new ReglageType(), $reglage);
        $display_tab = 1;
        //selectionne les seuls reglages materiel actifs
        $reglages = $repositoryReglage->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:reglage.html.twig', array('reglages' => $reglages, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Reglage entity.
     *
     * @Route("/new-reglage")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $reglage = new Reglage();
        $reglageUnique = new Reglage();
        $form = $this->createForm(new ReglageType(), $reglage);
        $form->handleRequest($request);
        $repositoryReglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Reglage");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $reglageUnique = $repositoryReglage->findBy(array("nom" => $reglage->getNom(), "statut" => 1));
                if ($reglageUnique == null) {
                    try {
                        $idoperations = $request->request->get("idoperations");
                        //add others exists operations to a reglage
                        if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                            foreach ($idoperations as $idoperation) {
                                $idoperation = (int) $idoperation;
                                $operation = $repositoryOperation->find($idoperation);
                                if (false === $reglage->getOperations()->contains($operation)) {
                                    $reglage->getOperations()->add($operation);
                                    $operation->getReglages()->add($reglage);
                                    $repositoryOperation->updateOperation($operation);
                                }
                            }
                        }
                        $repositoryReglage->saveReglage($reglage);
                        $message = $this->get('translator')->trans('Reglage.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $reglage = new Reglage();
                        $form = $this->createForm(new ReglageType(), $reglage);
                        return $this->render('NNGenieMaintenanceBundle:Reglages:form-add-reglage.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Reglage.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Reglages:form-add-reglage.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    }
                } else {
                    $message = $this->get('translator')->trans('Reglage.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Reglages:form-add-reglage.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Reglages:form-add-reglage.html.twig', array('form' => $form->createView(), 'operations' => $operations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_reglages'));
        }
    }

    /**
     * Finds and displays a Reglage entity.
     *
     * @Route("/show-reglage/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Reglage $reglage) {
        $deleteForm = $this->createDeleteForm($reglage);

        return $this->render('reglage/show.html.twig', array(
                    'reglage' => $reglage,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Reglage entity.
     *
     * @Route("/edit-reglage/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Reglage $reglage) {
        $editForm = $this->createForm(new ReglageType(), $reglage);
        $editForm->handleRequest($request);
        $repositoryReglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Reglage");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $originalOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $othersOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        
        foreach ($operations as $operation) {
            if (!$reglage->getOperations()->contains($operation)) {
                $othersOperations->add($operation);
            }
        }
    
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idoperations = $request->request->get("idoperations");
                    foreach ($originalOperations as $operation) {
                        if (false === $reglage->getOperations()->contains($operation)) {
                            // remove the reglage from the operation
                            $operation->getReglages()->removeElement($reglage);
                            $repositoryOperation->updateOperation($operation);
                        }
                    }

                    //add others exists operations to a reglage
                    if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                        foreach ($idoperations as $idoperation) {
                            $idoperation = (int) $idoperation;
                            $operation = $repositoryOperation->find($idoperation);
                            if (false === $reglage->getOperations()->contains($operation)) {
                                $reglage->getOperations()->add($operation);
                                $operation->getReglages()->add($reglage);
                                $repositoryOperation->updateOperation($operation);
                            }
                        }
                    }
                    
                    $repositoryReglage->updateReglage($reglage);
                    $message = $this->get('translator')->trans('Reglage.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_reglages'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Reglage.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Reglages:form-update-reglage.html.twig', array('form' => $editForm->createView(), 'idreglage' => $reglage->getId(), 'operations' => $othersOperations));
                }
            }
            foreach ($reglage->getOperations() as $operation) {
                $originalOperations->add($operation);
            }
            return $this->render('NNGenieMaintenanceBundle:Reglages:form-update-reglage.html.twig', array('form' => $editForm->createView(), 'idreglage' => $reglage->getId(), 'operations' => $othersOperations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_reglages'));
        }
    }

    /**
     * Deletes a Reglage entity.
     *
     * @Route("/delete-reglage/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Reglage $reglage) {
        $request = $this->get("request");
        $repositoryReglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Reglage");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        if ($request->isMethod('GET')) {
            try {
                foreach ($reglage->getOperations() as $operation) {
                    $operation->getReglages()->removeElement($reglage);
                    $repositoryOperation->updateOperation($operation);
                }
                $repositoryReglage->deleteReglage($reglage);
                $message = $this->get('translator')->trans('Reglage.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_reglages'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Reglage.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_reglages'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_reglages'));
        }
    }

}
