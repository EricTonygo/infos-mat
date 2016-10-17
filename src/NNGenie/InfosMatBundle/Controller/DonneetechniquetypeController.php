<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Donneetechniquetype;
use NNGenie\InfosMatBundle\Entity\Type;
use NNGenie\InfosMatBundle\Form\DonneetechniquetypeType;

class DonneetechniquetypeController extends Controller {

    /**
     * @Route("/donnee-technique-types/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function donneetechniquetypesAction(Type $type) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $repositoryDonneetechniquetype = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Donneetechniquetype");
        //selectionne les seuls donneetechniquetypes actifs
        $donneetechniquetypes = $repositoryDonneetechniquetype->findBy(array("type" => $type, "statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Donneetechniquetypes:donneetechniquetypes.html.twig', array('donneetechniquetypes' => $donneetechniquetypes, 'type' => $type));
    }

    /**
     * Creates a new Donneetechniquetype entity.
     *
     * @Route("/new-donnee-technique-type/{id}")
     * @Template()
     * @Method({"POST","GET"})
     */
    public function newAction(Type $type) {
        $donneetechniquetype = new Donneetechniquetype();
        $request = $this->get("request");
        $form = $this->createForm(new DonneetechniquetypeType(), $donneetechniquetype);
        $form->handleRequest($request);
        $repositoryDonneetechniquetype = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Donneetechniquetype");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $donneetechniquetypeUnique = $repositoryDonneetechniquetype->findBy(array("donneetechnique" => $donneetechniquetype->getDonneetechnique(), "type" => $type, "statut" => 1));
                if ($donneetechniquetypeUnique == null) {                
                    try {
                        $donneetechniquetype->setType($type);
                        $repositoryDonneetechniquetype->saveDonneetechniquetype($donneetechniquetype);
                        $message = $this->get('translator')->trans('Donneetechniquetype.created_success', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        return $this->render('NNGenieInfosMatBundle:Donneetechniquetypes:form-add-donneetechniquetype.html.twig', array('form' => $form->createView(), 'type' => $type));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Donneetechniquetype.created_failure', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieInfosMatBundle:Donneetechniquetypes:form-add-donneetechniquetype.html.twig', array('form' => $form->createView(), 'type' => $type));
                    }
                } else {
                    $message = $this->get('translator')->trans('Donneetechniquetype.exist_already', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieInfosMatBundle:Donneetechniquetypes:form-add-donneetechniquetype.html.twig', array('form' => $form->createView(), 'type' => $type));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Donneetechniquetypes:form-add-donneetechniquetype.html.twig', array('form' => $form->createView(), 'type' => $type));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniquetypes', array("id" => $type->getId())));
        }
    }

    /**
     * Finds and displays a Donneetechniquetype entity.
     *
     * @Route("/show-donneetechniquetype/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Donneetechniquetype $donneetechniquetype) {
        $deleteForm = $this->createDeleteForm($donneetechniquetype);

        return $this->render('donneetechniquetype/show.html.twig', array(
                    'donneetechniquetype' => $donneetechniquetype,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Donneetechniquetype entity.
     *
     * @Route("/edit-donnee-technique-type/{id}")
     * @Template()
     * @Method({"POST","GET"})
     */
    public function editAction(Donneetechniquetype $donneetechniquetype) {
        // $deleteForm = $this->createDeleteForm($donneetechniquetype);
        $request = $this->get("request");
        $editForm = $this->createForm(new DonneetechniquetypeType(), $donneetechniquetype);
        $editForm->handleRequest($request);
        $repositoryDonneetechniquetype = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Donneetechniquetype");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryDonneetechniquetype->updateDonneetechniquetype($donneetechniquetype);
                    $message = $this->get('translator')->trans('Donneetechniquetype.updated_success', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniquetypes', array('id' => $donneetechniquetype->getType()->getId())));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Donneetechniquetype.updated_failure', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieInfosMatBundle:Donneetechniquetypes:form-update-donneetechniquetype.html.twig', array('form' => $editForm->createView(), 'donneetechniquetype' => $donneetechniquetype));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Donneetechniquetypes:form-update-donneetechniquetype.html.twig', array('form' => $editForm->createView(), 'donneetechniquetype' => $donneetechniquetype));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniquetypes', array("id" => $donneetechniquetype->getType()->getId())));
        }
    }

    /**
     * Deletes a Donneetechniquetype entity.
     *
     * @Route("/delete-donnee-technique-type/{id}")
     * @Template()
     * @Method("GET")
     */
    public function deleteAction(Donneetechniquetype $donneetechniquetype) {
        $request = $this->get("request");
        $repositoryDonneetechniquetype = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Donneetechniquetype");
        if ($request->isMethod('GET')) {
            try {
                $repositoryDonneetechniquetype->deleteDonneetechniquetype($donneetechniquetype);
                $message = $message = $this->get('translator')->trans('Donneetechniquetype.deleted_success', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniquetypes', array('id' => $donneetechniquetype->getType()->getId())));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Donneetechniquetype.deleted_failure', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniquetypes', array('id' => $donneetechniquetype->getType()->getId())));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniquetypes', array("id" => $donneetechniquetype->getType()->getId())));
        }
    }

    /**
     * Creates a form to delete a Donneetechniquetype entity.
     *
     * @param Donneetechniquetype $donneetechniquetype The Donneetechniquetype entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Donneetechniquetype $donneetechniquetype) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $donneetechniquetype->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Creates a form to add a Donneetechniquetype entity.
     *
     * @param Donneetechniquetype $donneetechniquetype The Donneetechniquetype entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_donneetechniquetype_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }

}
