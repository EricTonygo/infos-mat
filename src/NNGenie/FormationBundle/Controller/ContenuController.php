<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Contenuformation;
use NNGenie\FormationBundle\Form\ContenuformationType;


class ContenuController extends Controller
{
    /**
     * Creates a new Contenu entity.
     *
     * @Route("/Formation/new-contenu")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $contenu= new Contenuformation();
        $contenuUnique = new Contenuformation();
        $form = $this->createForm(new ContenuformationType(), $contenu);
        $form->handleRequest($request);
        $repositoryContenu = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Contenuformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $contenuUnique = $repositoryContenu->findBy(array("nom" => $contenu->getNom(),"statut" => 1));
                if ($contenuUnique == null) {
                    try {
                        $repositoryContenu->saveContenuformation($contenu);
                        $message = $this->get('translator')->trans('Contenu.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Contenuformation();
						$form = $this->createForm(new ContenuformationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Contenuformation:form-add-contenu.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Contenu.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Contenuformation:form-add-contenu.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Contenu.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Contenuformation:form-add-contenu.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Contenuformation:form-add-contenu.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_contenu'));
        }
    }
    
    /**
     * @Route("/Formation/contenus")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryContenu = $em->getRepository("NNGenieFormationBundle:Contenuformation");
        $contenu= new Contenuformation();
        $form = $this->createForm(new ContenuformationType(), $contenu);
        $display_tab = 1;
        //selectionne les seuls $contenus actifs
        $contenus = $repositoryContenu->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Contenuformation:contenu.html.twig', array('contenus' => $contenus, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Contenu entity.
     *
     * @Route("/delete-contenu/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Contenuformation $contenu) {
        $request = $this->get("request");
        $repositoryContenu = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Contenuformation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryContenu->deleteContenuformation($contenu);
                $message = $message = $this->get('translator')->trans('Contenu.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_contenu'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Contenu.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_contenu'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_contenu'));
        }
    }
    
     /**
     * Displays a form to edit an existing Contenu entity.
     *
     * @Route("/edit-contenu/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Contenuformation $contenu) {
        // $deleteForm = $this->createDeleteForm($contenu);        
        $editForm = $this->createForm(new ContenuformationType(), $contenu);
        $editForm->handleRequest($request);
        $repositoryContenu = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Contenuformation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryContenu->updateContenuformation($contenu);
                    $message = $this->get('translator')->trans('Contenu.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_contenu'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Contenu.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Contenuformation:form-update-contenu.html.twig', array('form' => $editForm->createView(), 'idcontenu' => $contenu->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Contenuformation:form-update-contenu.html.twig', array('form' => $editForm->createView(), 'idcontenu' => $contenu->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_contenu'));
        }
    }

}
