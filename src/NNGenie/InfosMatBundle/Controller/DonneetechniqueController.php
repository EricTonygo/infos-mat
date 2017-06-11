<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Donneetechnique;
use NNGenie\InfosMatBundle\Form\DonneetechniqueType;

/**
 * Donneetechnique controller.
 *
 */
class DonneetechniqueController extends Controller {

    /**
     * @Route("/donneetechniques")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function donneetechniquesAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryDonneetechnique = $em->getRepository("NNGenieInfosMatBundle:Donneetechnique");
        $donneetechnique = new Donneetechnique();
        $form = $this->createForm(new DonneetechniqueType(), $donneetechnique);
        $display_tab = 1;
        //selectionne les seuls donneetechniques actifs
        $donneetechniques = $repositoryDonneetechnique->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Donneetechniques:donneetechniques.html.twig', array('donneetechniques' => $donneetechniques, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * @Route("/donneetechniquesuser")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function donneetechniquesuserAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryDonneetechnique = $em->getRepository("NNGenieInfosMatBundle:Donneetechnique");

        //selectionne les seuls donneetechniques actifs
        $donneetechniques = $repositoryDonneetechnique->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:FrontEnd:donneetechniques.html.twig', array('donneetechniques' => $donneetechniques));
    }

    /**
     * Creates a new Donneetechnique entity.
     *
     * @Route("/new-donneetechnique")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $donneetechnique = new Donneetechnique();
        $donneetechniqueUnique = new Donneetechnique();
        $form = $this->createForm(new DonneetechniqueType(), $donneetechnique);
        $form->handleRequest($request);
        $repositoryDonneetechnique = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Donneetechnique");
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $donneetechniqueUnique = $repositoryDonneetechnique->findOneBy(array("nom" => $donneetechnique->getNom(), "statut" => 1));
                    if ($donneetechniqueUnique == null) {
                        $repositoryDonneetechnique->saveDonneetechnique($donneetechnique);
                        $message = $this->get('translator')->trans('Donneetechnique.created_success', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $donneetechnique = new Donneetechnique();
                        $form = $this->createForm(new DonneetechniqueType(), $donneetechnique);
                    } else {
                        $message = $this->get('translator')->trans('Donneetechnique.exist_already', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    }
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Donneetechnique.created_failure', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                }
            }
            return $this->render('NNGenieInfosMatBundle:Donneetechniques:form-add-donneetechnique.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniques'));
        }
    }

    /**
     * Finds and displays a Donneetechnique entity.
     *
     * @Route("/show-donneetechnique/{id}", name="post_admin_show")
     * @Method({"POST", "GET"})
     */
    public function showAction(Donneetechnique $donneetechnique) {
        $deleteForm = $this->createDeleteForm($donneetechnique);

        return $this->render('donneetechnique/show.html.twig', array(
                    'donneetechnique' => $donneetechnique,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Donneetechnique entity.
     *
     * @Route("/edit-donneetechnique/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Donneetechnique $donneetechnique) {
        // $deleteForm = $this->createDeleteForm($donneetechnique);
        $editForm = $this->createForm(new DonneetechniqueType(), $donneetechnique);
        $editForm->handleRequest($request);
        $repositoryDonneetechnique = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Donneetechnique");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $donneetechniqueUnique = $repositoryDonneetechnique->findOneBy(array("nom" => $donneetechnique->getNom(), "statut" => 1));
                try {
                    if ($donneetechniqueUnique && $donneetechniqueUnique->getId() != $donneetechnique->getId()) {
                        $message = $this->get('translator')->trans('Donneetechnique.exist_already', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    } else {
                        $repositoryDonneetechnique->updateDonneetechnique($donneetechnique);
                        $message = $this->get('translator')->trans('Donneetechnique.updated_success', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniques'));
                    }
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Donneetechnique.updated_failure', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                }
            }
            return $this->render('NNGenieInfosMatBundle:Donneetechniques:form-update-donneetechnique.html.twig', array('form' => $editForm->createView(), 'iddonneetechnique' => $donneetechnique->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniques'));
        }
    }

    /**
     * Deletes a Donneetechnique entity.
     *
     * @Route("/delete-donneetechnique/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Donneetechnique $donneetechnique) {
        $request = $this->get("request");
        $repositoryDonneetechnique = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Donneetechnique");
        if ($request->isMethod("GET")) {
            try {
                $repositoryDonneetechnique->deleteDonneetechnique($donneetechnique);
                $message = $message = $this->get('translator')->trans('Donneetechnique.deleted_success', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniques'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Donneetechnique.deleted_failure', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniques'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_donneetechniques'));
        }
    }

    /**
     * Creates a form to delete a Donneetechnique entity.
     *
     * @param Donneetechnique $donneetechnique The Donneetechnique entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Donneetechnique $donneetechnique) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $donneetechnique->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Creates a form to add a Donneetechnique entity.
     *
     * @param Donneetechnique $donneetechnique The Donneetechnique entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_donneetechnique_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }

}
