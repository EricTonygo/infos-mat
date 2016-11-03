<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Revision;
use NNGenie\MaintenanceBundle\Form\RevisionType;

/**
 * Revision controller.
 *
 */
class RevisionController extends Controller {

    /**
     * @Route("/revisions")
     * @Template()
     */
    public function revisionsAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryRevision = $em->getRepository("NNGenieMaintenanceBundle:Revision");
        $revision = new Revision();
        $form = $this->createForm(new RevisionType(), $revision);
        //selectionne les seuls revisions materiel actifs
        $revisions = $repositoryRevision->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Revisions:revisions.html.twig', array('revisions' => $revisions, 'form' => $form->createView()));
    }

    /**
     * @Route("/revisions-user")
     * @Template()
     */
    public function revisionsuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryRevision = $em->getRepository("NNGenieMaintenanceBundle:Revision");
        $revision = new Revision();
        $form = $this->createForm(new RevisionType(), $revision);
        $display_tab = 1;
        //selectionne les seuls revisions materiel actifs
        $revisions = $repositoryRevision->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:revision.html.twig', array('revisions' => $revisions, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Revision entity.
     *
     * @Route("/new-revision")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $revision = new Revision();
        $revisionUnique = new Revision();
        $form = $this->createForm(new RevisionType(), $revision);
        $form->handleRequest($request);
        $repositoryRevision = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Revision");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $revisionUnique = $repositoryRevision->findBy(array("nom" => $revision->getNom(), "statut" => 1));
                if ($revisionUnique == null) {
                    try {
                        $idoperations = $request->request->get("idoperations");
                        //add others exists operations to a revision
                        if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                            foreach ($idoperations as $idoperation) {
                                $idoperation = (int) $idoperation;
                                $operation = $repositoryOperation->find($idoperation);
                                if (false === $revision->getOperations()->contains($operation)) {
                                    $revision->getOperations()->add($operation);
                                    $operation->getRevisions()->add($revision);
                                    $repositoryOperation->updateOperation($operation);
                                }
                            }
                        }
                        $repositoryRevision->saveRevision($revision);
                        $message = $this->get('translator')->trans('Revision.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $revision = new Revision();
                        $form = $this->createForm(new RevisionType(), $revision);
                        return $this->render('NNGenieMaintenanceBundle:Revisions:form-add-revision.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Revision.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Revisions:form-add-revision.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    }
                } else {
                    $message = $this->get('translator')->trans('Revision.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Revisions:form-add-revision.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Revisions:form-add-revision.html.twig', array('form' => $form->createView(), 'operations' => $operations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_revisions'));
        }
    }

    /**
     * Finds and displays a Revision entity.
     *
     * @Route("/show-revision/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Revision $revision) {
        $deleteForm = $this->createDeleteForm($revision);

        return $this->render('revision/show.html.twig', array(
                    'revision' => $revision,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Revision entity.
     *
     * @Route("/edit-revision/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Revision $revision) {
        $editForm = $this->createForm(new RevisionType(), $revision);
        $editForm->handleRequest($request);
        $repositoryRevision = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Revision");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $originalOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $othersOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        
        foreach ($operations as $operation) {
            if (!$revision->getOperations()->contains($operation)) {
                $othersOperations->add($operation);
            }
        }
    
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idoperations = $request->request->get("idoperations");
                    foreach ($originalOperations as $operation) {
                        if (false === $revision->getOperations()->contains($operation)) {
                            // remove the revision from the operation
                            $operation->getRevisions()->removeElement($revision);
                            $repositoryOperation->updateOperation($operation);
                        }
                    }

                    //add others exists operations to a revision
                    if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                        foreach ($idoperations as $idoperation) {
                            $idoperation = (int) $idoperation;
                            $operation = $repositoryOperation->find($idoperation);
                            if (false === $revision->getOperations()->contains($operation)) {
                                $revision->getOperations()->add($operation);
                                $operation->getRevisions()->add($revision);
                                $repositoryOperation->updateOperation($operation);
                            }
                        }
                    }
                    
                    $repositoryRevision->updateRevision($revision);
                    $message = $this->get('translator')->trans('Revision.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_revisions'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Revision.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Revisions:form-update-revision.html.twig', array('form' => $editForm->createView(), 'idrevision' => $revision->getId(), 'operations' => $othersOperations));
                }
            }
            foreach ($revision->getOperations() as $operation) {
                $originalOperations->add($operation);
            }
            return $this->render('NNGenieMaintenanceBundle:Revisions:form-update-revision.html.twig', array('form' => $editForm->createView(), 'idrevision' => $revision->getId(), 'operations' => $othersOperations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_revisions'));
        }
    }

    /**
     * Deletes a Revision entity.
     *
     * @Route("/delete-revision/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Revision $revision) {
        $request = $this->get("request");
        $repositoryRevision = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Revision");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        if ($request->isMethod('GET')) {
            try {
                foreach ($revision->getOperations() as $operation) {
                    $operation->getRevisions()->removeElement($revision);
                    $repositoryOperation->updateOperation($operation);
                }
                $repositoryRevision->deleteRevision($revision);
                $message = $this->get('translator')->trans('Revision.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_revisions'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Revision.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_revisions'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_revisions'));
        }
    }

}
