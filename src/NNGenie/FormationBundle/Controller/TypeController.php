<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Typeformation;
use NNGenie\FormationBundle\Form\TypeformationType;


class TypeController extends Controller
{
    /**
     * Creates a new Type entity.
     *
     * @Route("/Formation/new-type")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $type= new Typeformation();
        $typeUnique = new Typeformation();
        $form = $this->createForm(new TypeformationType(), $type);
        $form->handleRequest($request);
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Typeformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $typeUnique = $repositoryType->findBy(array("nom" => $type->getNom(),"statut" => 1));
                if ($typeUnique == null) {
                    try {
                        $repositoryType->saveTypeformation($type);
                        $message = $this->get('translator')->trans('Type.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Typeformation();
						$form = $this->createForm(new TypeformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Typeformation:form-add-type.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Type.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Typeformation:form-add-type.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Type.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Typeformation:form-add-type.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Typeformation:form-add-type.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_type'));
        }
    }
    
    /**
     * @Route("/Formation/types")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryType = $em->getRepository("NNGenieFormationBundle:Typeformation");
        $type= new Typeformation();
        $form = $this->createForm(new TypeformationType(), $type);
        $display_tab = 1;
        //selectionne les seuls $types actifs
        $types = $repositoryType->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Typeformation:type.html.twig', array('types' => $types, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Type entity.
     *
     * @Route("/delete-type/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Typeformation $type) {
        $request = $this->get("request");
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Typeformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryType->deleteTypeformation($type);
                $message = $message = $this->get('translator')->trans('Type.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_type'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Type.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_type'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_type'));
        }
    }
    
     /**
     * Displays a form to edit an existing Type entity.
     *
     * @Route("/edit-type/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Typeformation $type) {
        // $deleteForm = $this->createDeleteForm($type);        
        $editForm = $this->createForm(new TypeformationType(), $type);
        $editForm->handleRequest($request);
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Typeformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryType->updateTypeformation($type);
                    $message = $this->get('translator')->trans('Type.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_type'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Type.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Typeformation:form-update-type.html.twig', array('form' => $editForm->createView(), 'idtype' => $type->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Typeformation:form-update-type.html.twig', array('form' => $editForm->createView(), 'idtype' => $type->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_type'));
        }
    }

}
