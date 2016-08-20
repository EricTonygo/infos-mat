<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Classemateriel;
use NNGenie\InfosMatBundle\Form\ClassematerielType;

/**
 * Classemateriel controller.
 *
 */
class ClassematerielController extends Controller {

    /**
     * @Route("/classes-materiel")
     * @Template()
     */
    public function classesmaterielAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryClassemateriel = $em->getRepository("NNGenieInfosMatBundle:Classemateriel");
        $classemateriel = new Classemateriel();
        $form = $this->createForm(new ClassematerielType(), $classemateriel);
        $display_tab = 1;
        //selectionne les seuls classes materiel actifs
        $classesmateriel = $repositoryClassemateriel->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:ClassesMateriel:classesmateriel.html.twig', array('classesmateriel' => $classesmateriel, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
	
	
    /**
     * Creates a new Classemateriel entity.
     *
     * @Route("/new-classe-materiel")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $classemateriel = new Classemateriel();
        $classematerielUnique = new Classemateriel();
        $form = $this->createForm(new ClassematerielType(), $classemateriel);
        $form->handleRequest($request);
        $repositoryClassemateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Classemateriel");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $classematerielUnique = $repositoryClassemateriel->findBy(array("nom" => $classemateriel->getNom()));
                if ($classematerielUnique == null) {
                    try {
                        $repositoryClassemateriel->saveClassemateriel($classemateriel);
                        $message = $this->get('translator')->trans('Classemateriel.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_classesmateriel'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Classemateriel.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieInfosMatBundle:ClassesMateriel:form-add-classemateriel.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Classemateriel.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:ClassesMateriel:form-add-classemateriel.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:ClassesMateriel:form-add-classemateriel.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_classemateriels'));
        }
    }

    /**
     * Finds and displays a Classemateriel entity.
     *
     * @Route("/show-classemateriel/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Classemateriel $classemateriel) {
        $deleteForm = $this->createDeleteForm($classemateriel);

        return $this->render('classemateriel/show.html.twig', array(
                    'classemateriel' => $classemateriel,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Classemateriel entity.
     *
     * @Route("/edit-classe-materiel/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Classemateriel $classemateriel) {
        // $deleteForm = $this->createDeleteForm($classemateriel);
        $editForm = $this->createForm(new ClassematerielType(), $classemateriel);
        $editForm->handleRequest($request);
        $repositoryClassemateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Classemateriel");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryClassemateriel->updateClassemateriel($classemateriel);
                    $message = $this->get('translator')->trans('Classemateriel.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_classesmateriel'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Classemateriel.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                     return $this->render('NNGenieInfosMatBundle:ClassesMateriel:form-update-classemateriel.html.twig', array('form' => $editForm->createView(), 'idclasse' => $classemateriel->getId()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:ClassesMateriel:form-update-classemateriel.html.twig', array('form' => $editForm->createView(), 'idclasse' => $classemateriel->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_classesmateriel'));
        }
    }

    /**
     * Deletes a Classemateriel entity.
     *
     * @Route("/delete-classemateriel/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Classemateriel $classemateriel) {
        $request = $this->get("request");
        $repositoryClassemateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Classemateriel");
        if ($request->isMethod('GET')) {
            try {
                $repositoryClassemateriel->deleteClassemateriel($classemateriel);
                $message = $this->get('translator')->trans('Classemateriel.deleted_success', array(), "NNGenieInfosMatBundle");
				$request->getSession()->getFlashBag()->add('message_success', $message);
				return $this->redirect($this->generateUrl('nn_genie_infos_mat_classesmateriel'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Classemateriel.updated_failure', array(), "NNGenieInfosMatBundle");
				$request->getSession()->getFlashBag()->add('message_faillure', $message);
				return $this->redirect($this->generateUrl('nn_genie_infos_mat_classesmateriel'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_classesmateriel'));
        }
    }

    /**
     * Creates a form to delete a Classemateriel entity.
     *
     * @param Classemateriel $classemateriel The Classemateriel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Classemateriel $classemateriel) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $classemateriel->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    /**
     * Creates a form to add a Classemateriel entity.
     *
     * @param Classemateriel $classemateriel The Classemateriel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_classemateriel_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
}
