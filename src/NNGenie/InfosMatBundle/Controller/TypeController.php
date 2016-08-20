<?php


namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Type;
use NNGenie\InfosMatBundle\Form\TypeType;

/**
 * Type controller.
 *
 */
class TypeController extends Controller{
    
    /**
     * @Route("/types")
     * @Template()
     * @Method("GET, PUT")
     * @param Request $request
     */
    public function TypeAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
        $type = new Type();
        $form = $this->createForm(new TypeType(), $type);
        $display_tab = 1;
        //selectionne les seuls types actifs
        $types = $repositoryType->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Types:types.html.twig', array('types' => $types, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Type entity.
     *
     * @Route("/add-type")
     * @Template()
     * @Method("POST")
     * @param Request $request
     */
    public function newAction(Request $request) {
        $type = new Type();
        $typeUnique = new Type();
        $form = $this->createForm(new TypeType(), $type);
        $form->handleRequest($request);
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");

        if ($request->isMethod("POST")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $typeUnique = $repositoryType->findBy(array("nom" => $type->getNom()));
                if ($typeUnique != null) {
                    try {
                        $repositoryType->saveType($type);
                        $message = $this->get('translator')->trans('Type.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Type.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        $types = array();
                        $display_tab = 0;
                        return $this->render('NNGenieInfosMatBundle:Types:materiels.html.twig', array('types' => $types, 'form' => $form->createView(), "display_tab" => $display_tab));
                    }
                } else {
                    $message = $this->get('translator')->trans('Type.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    $types = array();
                    $display_tab = 0;
                    return $this->render('NNGenieInfosMatBundle:Types:materiels.html.twig', array('types' => $types, 'form' => $form->createView(), "display_tab" => $display_tab));
                }
            }
            $message = $this->get('translator')->trans('Type.created_failure', array(), "NNGenieInfosMatBundle");
            $request->getSession()->getFlashBag()->add('message_faillure', $message);
            $types = array();
            $display_tab = 0;
            return $this->render('NNGenieInfosMatBundle:Types:materiels.html.twig', array('types' => $types, 'form' => $form->createView(), "display_tab" => $display_tab));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
        }
    }

    /**
     * Finds and displays a Type entity.
     *
     * @Route("/show-type/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Type $type) {
        $deleteForm = $this->createDeleteForm($type);

        return $this->render('type/show.html.twig', array(
                    'type' => $type,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Type entity.
     *
     * @Route("/update-type/{id}")
     * @Template()
     * @Method("PUT")
     * @param Request $request
     */
    public function editAction(Request $request, Type $type) {
        // $deleteForm = $this->createDeleteForm($type);
        $editForm = $this->createForm(new TypeType(), $type);
        $editForm->handleRequest($request);
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");

        if ($request->isMethod("PUT")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryType->updateType($type);
                    $message = $this->get('translator')->trans('Type.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Type.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    $types = array();
                    $display_tab = 0;
                    return $this->render('NNGenieInfosMatBundle:Types:materiels.html.twig', array('types' => $types, 'form' => $editForm->createView(), "display_tab" => $display_tab));
                }
            }
            $message = $this->get('translator')->trans('Type.updated_failure', array(), "NNGenieInfosMatBundle");
            $request->getSession()->getFlashBag()->add('message_faillure', $message);
            $types = array();
            $display_tab = 0;
            return $this->render('NNGenieInfosMatBundle:Types:materiels.html.twig', array('types' => $types, 'form' => $editForm->createView(), "display_tab" => $display_tab));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
        }
    }

    /**
     * Deletes a Type entity.
     *
     * @Route("/update-type/{id}")
     * @Template()
     * @Method("DELETE")
     */
    public function deleteAction(Type $type) {
        $request = $this->get("request");
        $response = new JsonResponse();
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");
        if ($request->isMethod('DELETE')) {
            try {
                $repositoryType->deleteType($type);
                $message = $message = $this->get('translator')->trans('Type.deleted_success', array(), "NNGenieInfosMatBundle");
                $messages = array("letype" => "sucess", "message" => $message);
                return $response->setData(array("data" => $messages));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Type.deleted_failure', array(), "NNGenieInfosMatBundle");
                $messages = array("letype" => "error", "message" => $message);
                return $response->setData(array("data" => $messages));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
        }
    }

    /**
     * Creates a form to delete a Type entity.
     *
     * @param Type $type The Type entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Type $type) {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $type->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    /**
     * Creates a form to add a Type entity.
     *
     * @param Type $type The Type entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddForm() {
        return $this->createFormBuilder
                        ->setAction($this->generateUrl('nn_genie_infos_mat_type_add'))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
    
}
