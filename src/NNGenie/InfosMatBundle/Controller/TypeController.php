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
     * @Method({"GET"})
     * @param Request $request
     */
    public function typesAction(Request $request) {
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
     * @Route("/new-type")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $type = new Type();
        $typeUnique = new Type();
        $form = $this->createForm(new TypeType(), $type);
        $form->handleRequest($request);
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $typeUnique = $repositoryType->findBy(array("nom" => $type->getNom()));
                if ($typeUnique == null) {
                    try {
                        $repositoryType->saveType($type);
                        $message = $this->get('translator')->trans('Type.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Type.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieInfosMatBundle:Types:form-add-type.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Type.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Types:form-add-type.html.twig', array('form' => $form->createView()));
                }
            }
           return $this->render('NNGenieInfosMatBundle:Types:form-add-type.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
        }
    }

    /**
     * Finds and displays a Type entity.
     *
     * @Route("/show-type/{id}", name="post_admin_show")
     * @Method({"POST", "GET"})
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
     * @Route("/edit-type/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Type $type) {
        // $deleteForm = $this->createDeleteForm($type);
        $editForm = $this->createForm(new TypeType(), $type);
        $editForm->handleRequest($request);
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryType->updateType($type);
                    $message = $this->get('translator')->trans('Type.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Type.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Types:form-update-type.html.twig', array('form' => $editForm->createView(), 'idtype' => $type->getId()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Types:form-update-type.html.twig', array('form' => $editForm->createView(), 'idtype' => $type->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
        }
    }

    /**
     * Deletes a Type entity.
     *
     * @Route("/delete-type/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Type $type) {
        $request = $this->get("request");
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");
        if ($request->isMethod("GET")) {
            try {
                $repositoryType->deleteType($type);
                $message = $message = $this->get('translator')->trans('Type.deleted_success', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Type.deleted_failure', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_types'));
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
