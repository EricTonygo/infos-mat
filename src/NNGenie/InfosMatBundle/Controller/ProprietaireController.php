<?php


namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Proprietaire;
use NNGenie\InfosMatBundle\Form\ProprietaireType;

/**
 * Description of ProprietaireController
 *
 * @author TONYE
 */
class ProprietaireController extends Controller{
    
    /**
     * @Route("/proprietaires")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function proprietairesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryProprietaire = $em->getRepository("NNGenieInfosMatBundle:Proprietaire");
        $proprietaire = new Proprietaire();
        $form = $this->createForm(new ProprietaireType(), $proprietaire);
        $display_tab = 1;
        //selectionne les seuls proprietaires actifs
        $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Proprietaires:proprietaires.html.twig', array('proprietaires' => $proprietaires, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Proprietaire entity.
     *
     * @Route("/new-proprietaire")
     * @Template()
     * @Method({"POST","GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $proprietaire = new Proprietaire();
        $proprietaireUnique = new Proprietaire();
        $form = $this->createForm(new ProprietaireType(), $proprietaire);
        $form->handleRequest($request);
        $repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Proprietaire");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $proprietaireUnique = $repositoryProprietaire->findBy(array("nom" => $proprietaire->getNom(),"statut" => 1));
                if ($proprietaireUnique == null) {
                    try {
                        $repositoryProprietaire->saveProprietaire($proprietaire);
                        $message = $this->get('translator')->trans('Proprietaire.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $proprietaire = new Proprietaire();
						$form = $this->createForm(new ProprietaireType(), $proprietaire);
						return $this->render('NNGenieInfosMatBundle:Proprietaires:form-add-proprietaire.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Proprietaire.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieInfosMatBundle:Proprietaires:form-add-proprietaire.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Proprietaire.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Proprietaires:form-add-proprietaire.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Proprietaires:form-add-proprietaire.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_proprietaires'));
        }
    }

    /**
     * Finds and displays a Proprietaire entity.
     *
     * @Route("/show-proprietaire/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Proprietaire $proprietaire) {
        $deleteForm = $this->createDeleteForm($proprietaire);

        return $this->render('proprietaire/show.html.twig', array(
                    'proprietaire' => $proprietaire,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Proprietaire entity.
     *
     * @Route("/edit-proprietaire/{id}")
     * @Template()
     * @Method({"POST","GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Proprietaire $proprietaire) {
        // $deleteForm = $this->createDeleteForm($proprietaire);
        $editForm = $this->createForm(new ProprietaireType(), $proprietaire);
        $editForm->handleRequest($request);
        $repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Proprietaire");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryProprietaire->updateProprietaire($proprietaire);
                    $message = $this->get('translator')->trans('Proprietaire.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_proprietaires'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Proprietaire.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Proprietaires:form-update-proprietaire.html.twig', array('form' => $editForm->createView(), 'idproprietaire' => $proprietaire->getId()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Proprietaires:form-update-proprietaire.html.twig', array('form' => $editForm->createView(), 'idproprietaire' => $proprietaire->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_proprietaires'));
        }
    }

    /**
     * Deletes a Proprietaire entity.
     *
     * @Route("/delete-proprietaire/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Proprietaire $proprietaire) {
        $request = $this->get("request");
        $repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Proprietaire");
        if ($request->isMethod('GET')) {
            try {
                $repositoryProprietaire->deleteProprietaire($proprietaire);
                $message = $message = $this->get('translator')->trans('Proprietaire.deleted_success', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
				return $this->redirect($this->generateUrl('nn_genie_infos_mat_proprietaires'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Proprietaire.deleted_failure', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
				return $this->redirect($this->generateUrl('nn_genie_infos_mat_proprietaires'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_proprietaires'));
        }
    }

    /**
     * Creates a form to delete a Proprietaire entity.
     *
     * @param Proprietaire $proprietaire The Proprietaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Proprietaire $proprietaire) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $proprietaire->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    /**
     * Creates a form to add a Proprietaire entity.
     *
     * @param Proprietaire $proprietaire The Proprietaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_proprietaire_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
}
