<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Typereglage;
use NNGenie\MaintenanceBundle\Entity\Reglage;
use NNGenie\MaintenanceBundle\Form\TypereglageType;

/**
 * Typereglage controller.
 *
 */
class TypereglageController extends Controller {

    /**
     * @Route("/types-reglage")
     * @Template()
     */
    public function typereglagesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryTypereglage = $em->getRepository("NNGenieMaintenanceBundle:Typereglage");
        $typereglage = new Typereglage();
        $form = $this->createForm(new TypereglageType(), $typereglage);
        //selectionne les seuls typereglages materiel actifs
        $typereglages = $repositoryTypereglage->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Typereglages:typereglages.html.twig', array('typereglages' => $typereglages, 'form' => $form->createView()));
    }

    /**
     * @Route("/type-reglages-user")
     * @Template()
     */
    public function typereglagesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryTypereglage = $em->getRepository("NNGenieMaintenanceBundle:Typereglage");
        $typereglage = new Typereglage();
        $form = $this->createForm(new TypereglageType(), $typereglage);
        $display_tab = 1;
        //selectionne les seuls typereglages materiel actifs
        $typereglages = $repositoryTypereglage->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:typereglage.html.twig', array('typereglages' => $typereglages, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Typereglage entity.
     *
     * @Route("/new-type-reglage")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $typereglage = new Typereglage();
        $reglage = new Reglage();
        $form = $this->createForm(new TypereglageType(), $typereglage);
        $form->handleRequest($request);
        $repositoryTypereglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Typereglage");
        /*$repositoryReglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Reglage");
        $reglages = $repositoryReglage->findBy(array("statut" => 1));*/
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $typereglageUnique = $repositoryTypereglage->findBy(array("nom" => $typereglage->getNom(), "statut" => 1));
                if ($typereglageUnique == null) {
                    try {
                        /*foreach ($typereglage->getReglages() as $reglage) {
                            $reglage->setTypereglage($typereglage);
                        }*/
                        $repositoryTypereglage->saveTypereglage($typereglage);
                        $message = $this->get('translator')->trans('Typereglage.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $typereglage = new Typereglage();
                        $form = $this->createForm(new TypereglageType(), $typereglage);
                        return $this->render('NNGenieMaintenanceBundle:Typereglages:form-add-typereglage.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Typereglage.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Typereglages:form-add-typereglage.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Typereglage.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Typereglages:form-add-typereglage.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Typereglages:form-add-typereglage.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_typereglages'));
        }
    }

    /**
     * Finds and displays a Typereglage entity.
     *
     * @Route("/show-type-reglage/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Typereglage $typereglage) {
        $deleteForm = $this->createDeleteForm($typereglage);

        return $this->render('typereglage/show.html.twig', array(
                    'typereglage' => $typereglage,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Typereglage entity.
     *
     * @Route("/edit-type-reglage/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Typereglage $typereglage) {
        $reglage = new Reglage();
        $editForm = $this->createForm(new TypereglageType(), $typereglage);
        $editForm->handleRequest($request);
        $repositoryTypereglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Typereglage");
        /*$repositoryReglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Reglage");
        $othersReglages = new \Doctrine\Common\Collections\ArrayCollection();
        $originalReglages = new \Doctrine\Common\Collections\ArrayCollection();
        $reglages = $repositoryReglage->findBy(array("statut" => 1));
        foreach ($reglages as $reglage) {
            if (!$typereglage->getReglages()->contains($reglage)) {
                $othersReglages->add($reglage);
            }
        }*/
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    // remove the relationship between the tag and the Task
                    /*foreach ($originalReglages as $reglage) {
                        if (false === $typereglage->getReglages()->contains($reglage)) {
                            // remove the typereglage from the reglage
                            //$reglage->getTypereglages()->removeElement($typereglage);
                            // if it was a many-to-one relationship, remove the relationship like this

                            $repositoryReglage->deleteReglage($reglage);

                            // if you wanted to delete the Reglage entirely, you can also do that
                            // $em->remove($reglage);
                        }
                    }*/
                    $repositoryTypereglage->updateTypereglage($typereglage);
                    $message = $this->get('translator')->trans('Typereglage.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_typereglages'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Typereglage.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Typereglages:form-update-typereglage.html.twig', array('form' => $editForm->createView(), 'idtypereglage' => $typereglage->getId()));
                }
            }
            /*foreach ($typereglage->getReglages() as $reglage) {
                $originalReglages->add($reglage);
            }*/
            return $this->render('NNGenieMaintenanceBundle:Typereglages:form-update-typereglage.html.twig', array('form' => $editForm->createView(), 'idtypereglage' => $typereglage->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_typereglages'));
        }
    }

    /**
     * Deletes a Typereglage entity.
     *
     * @Route("/delete-type-reglage/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Typereglage $typereglage) {
        $request = $this->get("request");
        $repositoryTypereglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Typereglage");
        $repositoryReglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Reglage");
        $reglage = new Reglage();
        if ($request->isMethod('GET')) {
            try {
                foreach ($typereglage->getReglages() as $reglage) {
                    $repositoryReglage->deleteReglage($reglage);
                }
                $repositoryTypereglage->deleteTypereglage($typereglage);
                $message = $this->get('translator')->trans('Typereglage.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_typereglages'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Typereglage.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_typereglages'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_typereglages'));
        }
    }

}
