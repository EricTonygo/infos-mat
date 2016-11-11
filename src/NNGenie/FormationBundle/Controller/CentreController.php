<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Centreformation;
use NNGenie\FormationBundle\Form\CentreformationType;


class CentreController extends Controller
{
    /**
     * Creates a new Centre entity.
     *
     * @Route("/Formation/new-centre")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $centre= new Centreformation();
        $centreUnique = new Centreformation();
        $form = $this->createForm(new CentreformationType(), $centre);
        $form->handleRequest($request);
        $repositoryCentre = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Centreformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $centreUnique = $repositoryCentre->findBy(array("nom" => $centre->getNom(),"statut" => 1));
                if ($centreUnique == null) {
                    try {
                        $repositoryCentre->saveCentreformation($centre);
                        $message = $this->get('translator')->trans('Centre.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Centreformation();
						$form = $this->createForm(new CentreformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Centreformation:form-add-centre.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Centre.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Centreformation:form-add-centre.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Centre.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Centreformation:form-add-centre.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Centreformation:form-add-centre.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_centre'));
        }
    }
    
    /**
     * @Route("/Formation/centres")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryCentre = $em->getRepository("NNGenieFormationBundle:Centreformation");
        $centre= new Centreformation();
        $form = $this->createForm(new CentreformationType(), $centre);
        $display_tab = 1;
        //selectionne les seuls $centres actifs
        $centres = $repositoryCentre->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Centreformation:centre.html.twig', array('centres' => $centres, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Centre entity.
     *
     * @Route("/delete-centre/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Centreformation $centre) {
        $request = $this->get("request");
        $repositoryCentre = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Centreformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryCentre->deleteCentreformation($centre);
                $message = $message = $this->get('translator')->trans('Centre.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_centre'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Centre.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_centre'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_centre'));
        }
    }
    
     /**
     * Displays a form to edit an existing Centre entity.
     *
     * @Route("/edit-centre/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Centreformation $centre) {
        // $deleteForm = $this->createDeleteForm($centre);        
        $editForm = $this->createForm(new CentreformationType(), $centre);
        $editForm->handleRequest($request);
        $repositoryCentre = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Centreformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryCentre->updateCentreformation($centre);
                    $message = $this->get('translator')->trans('Centre.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_centre'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Centre.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Centreformation:form-update-centre.html.twig', array('form' => $editForm->createView(), 'idcentre' => $centre->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Centreformation:form-update-centre.html.twig', array('form' => $editForm->createView(), 'idcentre' => $centre->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_centre'));
        }
    }

}
