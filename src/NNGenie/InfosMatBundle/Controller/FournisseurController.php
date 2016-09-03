<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Fournisseur;
use NNGenie\InfosMatBundle\Form\FournisseurType;


class FournisseurController extends Controller{
    
    /**
     * @Route("/fournisseurs")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function fournisseursAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryFournisseur = $em->getRepository("NNGenieInfosMatBundle:Fournisseur");
        $fournisseur = new Fournisseur();
        $form = $this->createForm(new FournisseurType(), $fournisseur);
        $display_tab = 1;
        //selectionne les seuls fournisseurs actifs
        $fournisseurs = $repositoryFournisseur->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Fournisseurs:fournisseurs.html.twig', array('fournisseurs' => $fournisseurs, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Fournisseur entity.
     *
     * @Route("/new-fournisseur")
     * @Template()
     * @Method({"POST","GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $fournisseur = new Fournisseur();
        $fournisseurUnique = new Fournisseur();
        $form = $this->createForm(new FournisseurType(), $fournisseur);
        $form->handleRequest($request);
        $repositoryFournisseur = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Fournisseur");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $fournisseurUnique = $repositoryFournisseur->findBy(array("nom" => $fournisseur->getNom()));
                if ($fournisseurUnique == null) {
                    try {
                        $repositoryFournisseur->saveFournisseur($fournisseur);
                        $message = $this->get('translator')->trans('Fournisseur.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_fournisseurs'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Fournisseur.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieInfosMatBundle:Fournisseurs:form-add-fournisseur.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Fournisseur.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Fournisseurs:form-add-fournisseur.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Fournisseurs:form-add-fournisseur.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_fournisseurs'));
        }
    }

    /**
     * Finds and displays a Fournisseur entity.
     *
     * @Route("/show-fournisseur/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Fournisseur $fournisseur) {
        $deleteForm = $this->createDeleteForm($fournisseur);

        return $this->render('fournisseur/show.html.twig', array(
                    'fournisseur' => $fournisseur,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fournisseur entity.
     *
     * @Route("/edit-fournisseur/{id}")
     * @Template()
     * @Method({"POST","GET"})
     * @param Request $request
     */
    public function editAction(Fournisseur $fournisseur) {
        // $deleteForm = $this->createDeleteForm($fournisseur);
		$request = $this->get("request");
        $editForm = $this->createForm(new FournisseurType(), $fournisseur);
        $editForm->handleRequest($request);
        $repositoryFournisseur = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Fournisseur");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryFournisseur->updateFournisseur($fournisseur);
                    $message = $this->get('translator')->trans('Fournisseur.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_fournisseurs'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Fournisseur.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                     return $this->render('NNGenieInfosMatBundle:Fournisseurs:form-update-fournisseur.html.twig', array('form' => $editForm->createView(), 'idfournisseur' => $fournisseur->getId()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Fournisseurs:form-update-fournisseur.html.twig', array('form' => $editForm->createView(), 'idfournisseur' => $fournisseur->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_fournisseurs'));
        }
    }

    /**
     * Deletes a Fournisseur entity.
     *
     * @Route("/delete-fournisseur/{id}")
     * @Template()
     * @Method("GET")
     */
    public function deleteAction(Fournisseur $fournisseur) {
        $request = $this->get("request");
        $repositoryFournisseur = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Fournisseur");
        if ($request->isMethod('GET')) {
            try {
                $repositoryFournisseur->deleteFournisseur($fournisseur);
                $message = $message = $this->get('translator')->trans('Fournisseur.deleted_success', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
				return $this->redirect($this->generateUrl('nn_genie_infos_mat_fournisseurs'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Fournisseur.deleted_failure', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
				return $this->redirect($this->generateUrl('nn_genie_infos_mat_fournisseurs'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_fournisseurs'));
        }
    }

    /**
     * Creates a form to delete a Fournisseur entity.
     *
     * @param Fournisseur $fournisseur The Fournisseur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fournisseur $fournisseur) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $fournisseur->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    /**
     * Creates a form to add a Fournisseur entity.
     *
     * @param Fournisseur $fournisseur The Fournisseur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_fournisseur_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
}
