<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Responsableformation;
use NNGenie\FormationBundle\Form\ResponsableformationType;


class ResponsableController extends Controller
{
    /**
     * Creates a new Responsable entity.
     *
     * @Route("/Formation/new-responsable")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $responsable= new Responsableformation();
        $responsableUnique = new Responsableformation();
        $form = $this->createForm(new ResponsableformationType(), $responsable);
        $form->handleRequest($request);
        $repositoryResponsable = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Responsableformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $responsableUnique = $repositoryResponsable->findBy(array("nom" => $responsable->getNom(),"prenom" => $responsable->getPrenom(),"statut" => 1));
                if ($responsableUnique == null) {
                    try {
                        $repositoryResponsable->saveResponsableformation($responsable);
                        $message = $this->get('translator')->trans('Responsable.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Responsableformation();
						$form = $this->createForm(new ResponsableformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Responsableformation:form-add-responsable.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Responsable.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Responsableformation:form-add-responsable.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Responsable.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Responsableformation:form-add-responsable.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Responsableformation:form-add-responsable.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_responsable'));
        }
    }
    
    /**
     * @Route("/Formation/responsables")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryResponsable = $em->getRepository("NNGenieFormationBundle:Responsableformation");
        $responsable= new Responsableformation();
        $form = $this->createForm(new ResponsableformationType(), $responsable);
        $display_tab = 1;
        //selectionne les seuls $responsables actifs
        $responsables = $repositoryResponsable->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Responsableformation:responsable.html.twig', array('responsables' => $responsables, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Responsable entity.
     *
     * @Route("/delete-responsable/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Responsableformation $responsable) {
        $request = $this->get("request");
        $repositoryResponsable = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Responsableformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryResponsable->deleteResponsableformation($responsable);
                $message = $message = $this->get('translator')->trans('Responsable.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_responsable'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Responsable.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_responsable'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_responsable'));
        }
    }
    
     /**
     * Displays a form to edit an existing Responsable entity.
     *
     * @Route("/edit-responsable/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Responsableformation $responsable) {
        // $deleteForm = $this->createDeleteForm($responsable);        
        $editForm = $this->createForm(new ResponsableformationType(), $responsable);
        $editForm->handleRequest($request);
        $repositoryResponsable = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Responsableformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryResponsable->updateResponsableformation($responsable);
                    $message = $this->get('translator')->trans('Responsable.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_responsable'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Responsable.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Responsableformation:form-update-responsable.html.twig', array('form' => $editForm->createView(), 'idresponsable' => $responsable->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Responsableformation:form-update-responsable.html.twig', array('form' => $editForm->createView(), 'idresponsable' => $responsable->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_responsable'));
        }
    }

}
