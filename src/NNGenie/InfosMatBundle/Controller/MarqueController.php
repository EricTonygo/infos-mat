<?php


namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Marque;
use NNGenie\InfosMatBundle\Form\MarqueType;


/**
 * Marque controller.
 *
 */
class MarqueController extends Controller{
    
    /**
     * @Route("/marques")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function marquesAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryMarque = $em->getRepository("NNGenieInfosMatBundle:Marque");
        $marque = new Marque();
        $form = $this->createForm(new MarqueType(), $marque);
        $display_tab = 1;
        //selectionne les seuls marques actifs
        $marques = $repositoryMarque->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Marques:marques.html.twig', array('marques' => $marques, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Marque entity.
     *
     * @Route("/new-marque")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $marque = new Marque();
        $marqueUnique = new Marque();
        $form = $this->createForm(new MarqueType(), $marque);
        $form->handleRequest($request);
        $repositoryMarque = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Marque");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $marqueUnique = $repositoryMarque->findBy(array("nom" => $marque->getNom()));
                if ($marqueUnique == null) {
                    try {
                        $repositoryMarque->saveMarque($marque);
                        $message = $this->get('translator')->trans('Marque.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_marques'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Marque.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieInfosMatBundle:Marques:form-add-marque.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Marque.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Marques:form-add-marque.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Marques:form-add-marque.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_marques'));
        }
    }

    /**
     * Finds and displays a Marque entity.
     *
     * @Route("/show-marque/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Marque $marque) {
        $deleteForm = $this->createDeleteForm($marque);

        return $this->render('marque/show.html.twig', array(
                    'marque' => $marque,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Marque entity.
     *
     * @Route("/edit-marque/{id}")
     * @Template()
     * @Method({"POST","GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Marque $marque) {
        // $deleteForm = $this->createDeleteForm($marque);
        $editForm = $this->createForm(new MarqueType(), $marque);
        $editForm->handleRequest($request);
        $repositoryMarque = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Marque");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryMarque->updateMarque($marque);
                    $message = $this->get('translator')->trans('Marque.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_marques'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Marque.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Marques:form-update-marque.html.twig', array('form' => $editForm->createView(), 'idmarque' => $marque->getId()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Marques:form-update-marque.html.twig', array('form' => $editForm->createView(), 'idmarque' => $marque->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_marques'));
        }
    }

    /**
     * Deletes a Marque entity.
     *
     * @Route("/delete-marque/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Marque $marque) {
        $request = $this->get("request");
        $repositoryMarque = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Marque");
        if ($request->isMethod('GET')) {
            try {
                $repositoryMarque->deleteMarque($marque);
                $message = $message = $this->get('translator')->trans('Marque.deleted_success', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_marques'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Marque.deleted_failure', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_marques'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_marques'));
        }
    }

    /**
     * Creates a form to delete a Marque entity.
     *
     * @param Marque $marque The Marque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Marque $marque) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $marque->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    /**
     * Creates a form to add a Marque entity.
     *
     * @param Marque $marque The Marque entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_marque_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
}
