<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\FormationBundle\Entity\Formation;
use NNGenie\FormationBundle\Form\FormationType;


class FormationController extends Controller
{
    /**
     * Creates a new Formation entity.
     *
     * @Route("/Formation/new-formation")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function addAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $formation= new Formation();
        $formationUnique = new Formation();
        $form = $this->createForm(new FormationType(), $formation);
        $form->handleRequest($request);
        $repositoryFormation = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Formation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $formationUnique = $repositoryFormation->findBy(array("nom" => $formation->getNom(),"statut" => 1));
                if ($formationUnique == null) {
                    try {
                        $repositoryFormation->saveFormation($formation);
                        $message = $this->get('translator')->trans('Formation.created_success', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_success', $message);
                        $newqual = new Formation();
						$form = $this->createForm(new FormationType(), $newqual);
						return $this->render('NNGenieFormationBundle:Formation:form-add-formation.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Formation.created_failure', array(), "NNGenieFormationBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieFormationBundle:Formation:form-add-formation.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Formation.exist_already', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Formation:form-add-formation.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieFormationBundle:Formation:form-add-formation.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_formation'));
        }
    }
    
    /**
     * @Route("/Formation/formations")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function getAllAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryFormation = $em->getRepository("NNGenieFormationBundle:Formation");
        $formation= new Formation();
        $form = $this->createForm(new FormationType(), $formation);
        $display_tab = 1;
        //selectionne les seuls $formations actifs
        $formations = $repositoryFormation->findBy(array("statut" => 1));

        return $this->render('NNGenieFormationBundle:Formation:formation.html.twig', array('formations' => $formations, 'form' => $form->createView(), "display_tab" => $display_tab));
    }
    
    /**
     * Deletes a Formation entity.
     *
     * @Route("/delete-formation/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Formation $formation) {
        $request = $this->get("request");
        $repositoryFormation = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Formation");
        if ($request->isMethod('GET')) {
            try {
                $repositoryFormation->deleteFormation($formation);
                $message = $message = $this->get('translator')->trans('Formation.deleted_success', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_formation'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Formation.deleted_failure', array(), "NNGenieFormationBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_formation_view_formation'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_formation'));
        }
    }
    
     /**
     * Displays a form to edit an existing Formation entity.
     *
     * @Route("/edit-formation/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Formation $formation) {
        // $deleteForm = $this->createDeleteForm($formation);        
        $editForm = $this->createForm(new FormationType(), $formation);
        $editForm->handleRequest($request);
        $repositoryFormation = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Formation");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryFormation->updateFormation($formation);
                    $message = $this->get('translator')->trans('Formation.updated_success', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_formation_view_formation'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Formation.updated_failure', array(), "NNGenieFormationBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieFormationBundle:Formation:form-update-formation.html.twig', array('form' => $editForm->createView(), 'idformation' => $formation->getId()));
                }
            }
            return $this->render('NNGenieFormationBundle:Formation:form-update-formation.html.twig', array('form' => $editForm->createView(), 'idformation' => $formation->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_formation'));
        }
    }
    
    /**
     *
     * @Route("/detail-formation/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function detailAction(Formation $idformation) {
        $request = $this->get("request");
        $em = $this->getDoctrine()->getManager();
        $repositoryFormation = $em->getRepository("NNGenieFormationBundle:Formation");
        $repositoryCondition = $em->getRepository("NNGenieFormationBundle:Conditionformation");
        $repositoryTitulaire = $em->getRepository("NNGenieFormationBundle:Titulaireformation");
        $repositoryProgramme = $em->getRepository("NNGenieFormationBundle:Programmeformation");
        $repositoryCout = $em->getRepository("NNGenieFormationBundle:Coutformation");
        $repositoryContenu = $em->getRepository("NNGenieFormationBundle:Contenuformation");
        $parametres = array();
        if ($request->isMethod('GET')) {
            $formation = $repositoryFormation->findBy(array('id' => $idformation, 'statut' => 1));
            $condition = $repositoryCondition->findBy(array('formation' => $idformation, 'statut' => 1));
            $titulaire = $repositoryTitulaire->findBy(array('formation' => $idformation, 'statut' => 1));
            $programme = $repositoryProgramme->findBy(array('formation' => $idformation, 'statut' => 1));
            $cout = $repositoryCout->findBy(array('formation' => $idformation, 'statut' => 1));
            $contenu = $repositoryContenu->findBy(array('typeformation' => $idformation->getTypeformation(), 'statut' => 1));
            if(count($formation)>0){
                $parametres['formation'] = $formation[array_keys($formation)[0]];
            }
            if(count($condition)>0){
                $parametres['condition'] = $condition[array_keys($condition)[0]];
            }
            if(count($programme)>0){
                $parametres['programmes'] = $programme;
            }
            if(count($titulaire)>0){
                $parametres['titulaire'] = $titulaire[array_keys($titulaire)[0]];
            }
            if(count($cout)>0){
                $parametres['cout'] = $cout[array_keys($cout)[0]];
            }
            if(count($contenu)>0){
                $parametres['contenus'] = $contenu;
            }
            return $this->render('NNGenieFormationBundle:Formation:details-formation.html.twig', $parametres);
        } else {
            return $this->redirect($this->generateUrl('nn_genie_formation_view_formation'));
        }
    }

}
