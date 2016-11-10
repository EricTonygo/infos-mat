<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Titulaireformation;
use NNGenie\FormationBundle\Form\TitulaireformationType;


class TitulaireController extends Controller
{
    /**
     * Creates a new Titulaire entity.
     *
     * @Route("/Formation/new-titulaire")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $titulaire= new Titulaireformation();
        $titulaireUnique = new Titulaireformation();
        $form = $this->createForm(new TitulaireformationType(), $titulaire);
        $form->handleRequest($request);
        $repositoryTitulaire = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Titulaireformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $titulaireUnique = $repositoryTitulaire->findBy(array("formation" => $titulaire->getFormation(),"statut" => 1));
                if ($titulaireUnique == null) {
                    try {
                        $repositoryTitulaire->saveTitulaireformation($titulaire);
                        $message = $this->get('translator')->trans('Titulaire.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Titulaireformation();
						$form = $this->createForm(new TitulaireformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Titulaireformation:form-add-titulaire.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Titulaire.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Titulaireformation:form-add-titulaire.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Titulaire.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Titulaireformation:form-add-titulaire.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Titulaireformation:form-add-titulaire.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_titulaire'));
        }
    }
    
    /**
     * @Route("/Formation/titulaires")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryTitulaire = $em->getRepository("NNGenieFormationBundle:Titulaireformation");
        $titulaire= new Titulaireformation();
        $form = $this->createForm(new TitulaireformationType(), $titulaire);
        $display_tab = 1;
        //selectionne les seuls $titulaires actifs
        $titulaires = $repositoryTitulaire->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Titulaireformation:titulaire.html.twig', array('titulaires' => $titulaires, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Titulaire entity.
     *
     * @Route("/delete-titulaire/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Titulaireformation $titulaire) {
        $request = $this->get("request");
        $repositoryTitulaire = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Titulaireformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryTitulaire->deleteTitulaireformation($titulaire);
                $message = $message = $this->get('translator')->trans('Titulaire.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_titulaire'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Titulaire.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_titulaire'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_titulaire'));
        }
    }
    
     /**
     * Displays a form to edit an existing Titulaire entity.
     *
     * @Route("/edit-titulaire/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Titulaireformation $titulaire) {
        // $deleteForm = $this->createDeleteForm($titulaire);        
        $editForm = $this->createForm(new TitulaireformationType(), $titulaire);
        $editForm->handleRequest($request);
        $repositoryTitulaire = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Titulaireformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryTitulaire->updateTitulaireformation($titulaire);
                    $message = $this->get('translator')->trans('Titulaire.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_titulaire'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Titulaire.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Titulaireformation:form-update-titulaire.html.twig', array('form' => $editForm->createView(), 'idtitulaire' => $titulaire->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Titulaireformation:form-update-titulaire.html.twig', array('form' => $editForm->createView(), 'idtitulaire' => $titulaire->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_titulaire'));
        }
    }

}
