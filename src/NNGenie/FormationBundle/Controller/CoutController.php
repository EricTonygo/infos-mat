<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Coutformation;
use NNGenie\FormationBundle\Form\CoutformationType;


class CoutController extends Controller
{
    /**
     * Creates a new Cout entity.
     *
     * @Route("/Formation/new-cout")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $cout= new Coutformation();
        $coutUnique = new Coutformation();
        $form = $this->createForm(new CoutformationType(), $cout);
        $form->handleRequest($request);
        $repositoryCout = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Coutformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $coutUnique = $repositoryCout->findBy(array("formation" => $cout->getFormation(),"statut" => 1));
                if ($coutUnique == null) {
                    try {
                        $repositoryCout->saveCoutformation($cout);
                        $message = $this->get('translator')->trans('Cout.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Coutformation();
						$form = $this->createForm(new CoutformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Coutformation:form-add-cout.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Cout.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Coutformation:form-add-cout.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Cout.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Coutformation:form-add-cout.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Coutformation:form-add-cout.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_cout'));
        }
    }
    
    /**
     * @Route("/Formation/couts")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryCout = $em->getRepository("NNGenieFormationBundle:Coutformation");
        $cout= new Coutformation();
        $form = $this->createForm(new CoutformationType(), $cout);
        $display_tab = 1;
        //selectionne les seuls $couts actifs
        $couts = $repositoryCout->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Coutformation:cout.html.twig', array('couts' => $couts, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Cout entity.
     *
     * @Route("/delete-cout/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Coutformation $cout) {
        $request = $this->get("request");
        $repositoryCout = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Coutformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryCout->deleteCoutformation($cout);
                $message = $message = $this->get('translator')->trans('Cout.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_cout'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Cout.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_cout'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_cout'));
        }
    }
    
     /**
     * Displays a form to edit an existing Cout entity.
     *
     * @Route("/edit-cout/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Coutformation $cout) {
        // $deleteForm = $this->createDeleteForm($cout);        
        $editForm = $this->createForm(new CoutformationType(), $cout);
        $editForm->handleRequest($request);
        $repositoryCout = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Coutformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryCout->updateCoutformation($cout);
                    $message = $this->get('translator')->trans('Cout.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_cout'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Cout.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Coutformation:form-update-cout.html.twig', array('form' => $editForm->createView(), 'idcout' => $cout->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Coutformation:form-update-cout.html.twig', array('form' => $editForm->createView(), 'idcout' => $cout->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_cout'));
        }
    }

}
