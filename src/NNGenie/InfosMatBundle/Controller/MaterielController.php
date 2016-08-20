<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Materiel;
use NNGenie\InfosMatBundle\Form\MaterielType;

/**
 * Materiel controller.
 *
 */
class MaterielController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function accueilAction() {
        return $this->render('NNGenieInfosMatBundle:Administration:index.html.twig');
    }

    /**
     * @Route("/materiels")
     * @Template()
     * @Method("GET, PUT")
     * @param Request $request
     */
    public function MaterielAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $materiel = new Materiel();
        $form = $this->createForm(new MaterielType(), $materiel);
        $display_tab = 1;
        //selectionne les seuls materiels actifs
        $materiels = $repositoryMateriel->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Materiel entity.
     *
     * @Route("/add-materiel")
     * @Template()
     * @Method("POST")
     * @param Request $request
     */
    public function newAction(Request $request) {
        $materiel = new Materiel();
        $materielUnique = new Materiel();
        $form = $this->createForm(new MaterielType(), $materiel);
        $form->handleRequest($request);
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");

        if ($request->isMethod("POST")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $materielUnique = $repositoryMateriel->findBy(array("chassis" => $materiel->getChassis()));
                if ($materielUnique != null) {
                    try {
                        $repositoryMateriel->saveMateriel($materiel);
                        $message = $this->get('translator')->trans('Materiel.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Materiel.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        $materiels = array();
                        $display_tab = 0;
                        return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'form' => $form->createView(), "display_tab" => $display_tab));
                    }
                } else {
                    $message = $this->get('translator')->trans('Materiel.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    $materiels = array();
                    $display_tab = 0;
                    return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'form' => $form->createView(), "display_tab" => $display_tab));
                }
            }
            $message = $this->get('translator')->trans('Materiel.created_failure', array(), "NNGenieInfosMatBundle");
            $request->getSession()->getFlashBag()->add('message_faillure', $message);
            $materiels = array();
            $display_tab = 0;
            return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'form' => $form->createView(), "display_tab" => $display_tab));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Finds and displays a Materiel entity.
     *
     * @Route("/show-materiel/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Materiel $materiel) {
        $deleteForm = $this->createDeleteForm($materiel);

        return $this->render('materiel/show.html.twig', array(
                    'materiel' => $materiel,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Materiel entity.
     *
     * @Route("/update-materiel/{id}")
     * @Template()
     * @Method("PUT")
     * @param Request $request
     */
    public function editAction(Request $request, Materiel $materiel) {
        // $deleteForm = $this->createDeleteForm($materiel);
        $editForm = $this->createForm(new MaterielType(), $materiel);
        $editForm->handleRequest($request);
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");

        if ($request->isMethod("PUT")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryMateriel->updateMateriel($materiel);
                    $message = $this->get('translator')->trans('Materiel.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Materiel.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    $materiels = array();
                    $display_tab = 0;
                    return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'form' => $editForm->createView(), "display_tab" => $display_tab));
                }
            }
            $message = $this->get('translator')->trans('Materiel.updated_failure', array(), "NNGenieInfosMatBundle");
            $request->getSession()->getFlashBag()->add('message_faillure', $message);
            $materiels = array();
            $display_tab = 0;
            return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'form' => $editForm->createView(), "display_tab" => $display_tab));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Deletes a Materiel entity.
     *
     * @Route("/update-materiel/{id}")
     * @Template()
     * @Method("DELETE")
     */
    public function deleteAction(Materiel $materiel) {
        $request = $this->get("request");
        $response = new JsonResponse();
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");
        if ($request->isMethod('DELETE')) {
            try {
                $repositoryMateriel->deleteMateriel($materiel);
                $message = $message = $this->get('translator')->trans('Materiel.deleted_success', array(), "NNGenieInfosMatBundle");
                $messages = array("letype" => "sucess", "message" => $message);
                return $response->setData(array("data" => $messages));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Materiel.deleted_failure', array(), "NNGenieInfosMatBundle");
                $messages = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Creates a form to delete a Materiel entity.
     *
     * @param Materiel $materiel The Materiel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Materiel $materiel) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $materiel->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
