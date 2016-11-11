<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Conditionformation;
use NNGenie\FormationBundle\Form\ConditionformationType;


class ConditionController extends Controller
{
    /**
     * Creates a new Condition entity.
     *
     * @Route("/Formation/new-condition")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $condition= new Conditionformation();
        $conditionUnique = new Conditionformation();
        $form = $this->createForm(new ConditionformationType(), $condition);
        $form->handleRequest($request);
        $repositoryCondition = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Conditionformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $conditionUnique = $repositoryCondition->findBy(array("formation" => $condition->getFormation()));
                if ($conditionUnique == null) {
                    try {
                        $repositoryCondition->saveConditionformation($condition);
                        $message = $this->get('translator')->trans('Condition.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Conditionformation();
						$form = $this->createForm(new ConditionformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Conditionformation:form-add-condition.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Condition.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Conditionformation:form-add-condition.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Condition.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Conditionformation:form-add-condition.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Conditionformation:form-add-condition.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_condition'));
        }
    }
    
    /**
     * @Route("/Formation/conditions")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryCondition = $em->getRepository("NNGenieFormationBundle:Conditionformation");
        $condition= new Conditionformation();
        $form = $this->createForm(new ConditionformationType(), $condition);
        $display_tab = 1;
        //selectionne les seuls $conditions actifs
        $conditions = $repositoryCondition->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Conditionformation:condition.html.twig', array('conditions' => $conditions, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Condition entity.
     *
     * @Route("/delete-condition/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Conditionformation $condition) {
        $request = $this->get("request");
        $repositoryCondition = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Conditionformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryCondition->deleteConditionformation($condition);
                $message = $message = $this->get('translator')->trans('Condition.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_condition'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Condition.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_condition'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_condition'));
        }
    }
    
     /**
     * Displays a form to edit an existing Condition entity.
     *
     * @Route("/edit-condition/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Conditionformation $condition) {
        // $deleteForm = $this->createDeleteForm($condition);        
        $editForm = $this->createForm(new ConditionformationType(), $condition);
        $editForm->handleRequest($request);
        $repositoryCondition = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Conditionformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryCondition->updateConditionformation($condition);
                    $message = $this->get('translator')->trans('Condition.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_condition'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Condition.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Conditionformation:form-update-condition.html.twig', array('form' => $editForm->createView(), 'idcondition' => $condition->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Conditionformation:form-update-condition.html.twig', array('form' => $editForm->createView(), 'idcondition' => $condition->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_condition'));
        }
    }

}
