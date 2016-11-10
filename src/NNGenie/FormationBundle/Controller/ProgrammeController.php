<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Programmeformation;
use NNGenie\FormationBundle\Form\ProgrammeformationType;


class ProgrammeController extends Controller
{
    /**
     * Creates a new Programme entity.
     *
     * @Route("/Formation/new-programme")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $programme= new Programmeformation();
        $programmeUnique = new Programmeformation();
        $form = $this->createForm(new ProgrammeformationType(), $programme);
        $form->handleRequest($request);
        $repositoryProgramme = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Programmeformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $programmeUnique = $repositoryProgramme->findBy(array("formation" => $programme->getFormation(),"debut"=>$programme->getDebut(),"fin"=>$programme->getFin(),"statut" => 1));
                if ($programmeUnique == null) {
                    try {
                        $repositoryProgramme->saveProgrammeformation($programme);
                        $message = $this->get('translator')->trans('Programme.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Programmeformation();
						$form = $this->createForm(new ProgrammeformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Programmeformation:form-add-programme.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Programme.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Programmeformation:form-add-programme.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Programme.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Programmeformation:form-add-programme.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Programmeformation:form-add-programme.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_programme'));
        }
    }
    
    /**
     * @Route("/Formation/programmes")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryProgramme = $em->getRepository("NNGenieFormationBundle:Programmeformation");
        $programme= new Programmeformation();
        $form = $this->createForm(new ProgrammeformationType(), $programme);
        $display_tab = 1;
        //selectionne les seuls $programmes actifs
        $programmes = $repositoryProgramme->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Programmeformation:programme.html.twig', array('programmes' => $programmes, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Programme entity.
     *
     * @Route("/delete-programme/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Programmeformation $programme) {
        $request = $this->get("request");
        $repositoryProgramme = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Programmeformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryProgramme->deleteProgrammeformation($programme);
                $message = $message = $this->get('translator')->trans('Programme.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_programme'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Programme.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_programme'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_programme'));
        }
    }
    
     /**
     * Displays a form to edit an existing Programme entity.
     *
     * @Route("/edit-programme/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Programmeformation $programme) {
        // $deleteForm = $this->createDeleteForm($programme);        
        $editForm = $this->createForm(new ProgrammeformationType(), $programme);
        $editForm->handleRequest($request);
        $repositoryProgramme = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Programmeformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryProgramme->updateProgrammeformation($programme);
                    $message = $this->get('translator')->trans('Programme.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_programme'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Programme.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Programmeformation:form-update-programme.html.twig', array('form' => $editForm->createView(), 'idprogramme' => $programme->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Programmeformation:form-update-programme.html.twig', array('form' => $editForm->createView(), 'idprogramme' => $programme->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_programme'));
        }
    }

}
