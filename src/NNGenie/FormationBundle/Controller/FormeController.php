<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Formeformation;
use NNGenie\FormationBundle\Form\FormeformationType;


class FormeController extends Controller
{
    /**
     * Creates a new Forme entity.
     *
     * @Route("/Formation/new-forme")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $forme= new Formeformation();
        $formeUnique = new Formeformation();
        $form = $this->createForm(new FormeformationType(), $forme);
        $form->handleRequest($request);
        $repositoryForme = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Formeformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $formeUnique = $repositoryForme->findBy(array("nom" => $forme->getNom(),"statut" => 1));
                if ($formeUnique == null) {
                    try {
                        $repositoryForme->saveFormeformation($forme);
                        $message = $this->get('translator')->trans('Forme.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Formeformation();
						$form = $this->createForm(new FormeformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Formeformation:form-add-forme.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Forme.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Formeformation:form-add-forme.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Forme.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Formeformation:form-add-forme.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Formeformation:form-add-forme.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_forme'));
        }
    }
    
    /**
     * @Route("/Formation/formes")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryForme = $em->getRepository("NNGenieFormationBundle:Formeformation");
        $forme= new Formeformation();
        $form = $this->createForm(new FormeformationType(), $forme);
        $display_tab = 1;
        //selectionne les seuls $formes actifs
        $formes = $repositoryForme->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Formeformation:forme.html.twig', array('formes' => $formes, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Forme entity.
     *
     * @Route("/delete-forme/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Formeformation $forme) {
        $request = $this->get("request");
        $repositoryForme = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Formeformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryForme->deleteFormeformation($forme);
                $message = $message = $this->get('translator')->trans('Forme.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_forme'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Forme.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_forme'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_forme'));
        }
    }
    
     /**
     * Displays a form to edit an existing Forme entity.
     *
     * @Route("/edit-forme/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Formeformation $forme) {
        // $deleteForm = $this->createDeleteForm($forme);        
        $editForm = $this->createForm(new FormeformationType(), $forme);
        $editForm->handleRequest($request);
        $repositoryForme = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Formeformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryForme->updateFormeformation($forme);
                    $message = $this->get('translator')->trans('Forme.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_forme'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Forme.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Formeformation:form-update-forme.html.twig', array('form' => $editForm->createView(), 'idforme' => $forme->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Formeformation:form-update-forme.html.twig', array('form' => $editForm->createView(), 'idforme' => $forme->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_forme'));
        }
    }

}
