<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Proprete;
use NNGenie\MaintenanceBundle\Entity\Produit;
use NNGenie\MaintenanceBundle\Form\PropreteType;

/**
 * Proprete controller.
 *
 */
class PropreteController extends Controller {

    /**
     * @Route("/propretes")
     * @Template()
     */
    public function propretesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryProprete = $em->getRepository("NNGenieMaintenanceBundle:Proprete");
        $proprete = new Proprete();
        $form = $this->createForm(new PropreteType(), $proprete);
        //selectionne les seuls propretes materiel actifs
        $propretes = $repositoryProprete->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Propretes:propretes.html.twig', array('propretes' => $propretes, 'form' => $form->createView()));
    }

    /**
     * @Route("/propretes-user")
     * @Template()
     */
    public function propretesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryProprete = $em->getRepository("NNGenieMaintenanceBundle:Proprete");
        $proprete = new Proprete();
        $form = $this->createForm(new PropreteType(), $proprete);
        $display_tab = 1;
        //selectionne les seuls propretes materiel actifs
        $propretes = $repositoryProprete->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:proprete.html.twig', array('propretes' => $propretes, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Proprete entity.
     *
     * @Route("/new-proprete")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $proprete = new Proprete();
        $propreteUnique = new Proprete();
        $form = $this->createForm(new PropreteType(), $proprete);
        $form->handleRequest($request);
        $repositoryProprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Proprete");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $propreteUnique = $repositoryProprete->findBy(array("nom" => $proprete->getNom(), "statut" => 1));
                if ($propreteUnique == null) {
                    try {
                        $idoperations = $request->request->get("idoperations");
                        //add others exists operations to a proprete
                        if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                            foreach ($idoperations as $idoperation) {
                                $idoperation = (int) $idoperation;
                                $operation = $repositoryOperation->find($idoperation);
                                if (false === $proprete->getOperations()->contains($operation)) {
                                    $proprete->getOperations()->add($operation);
                                    $operation->getPropretes()->add($proprete);
                                    $repositoryOperation->updateOperation($operation);
                                }
                            }
                        }
                        $repositoryProprete->saveProprete($proprete);
                        $message = $this->get('translator')->trans('Proprete.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $proprete = new Proprete();
                        $form = $this->createForm(new PropreteType(), $proprete);
                        return $this->render('NNGenieMaintenanceBundle:Propretes:form-add-proprete.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Proprete.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Propretes:form-add-proprete.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    }
                } else {
                    $message = $this->get('translator')->trans('Proprete.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Propretes:form-add-proprete.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Propretes:form-add-proprete.html.twig', array('form' => $form->createView(), 'operations' => $operations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_propretes'));
        }
    }

    /**
     * Finds and displays a Proprete entity.
     *
     * @Route("/show-proprete/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Proprete $proprete) {
        $deleteForm = $this->createDeleteForm($proprete);

        return $this->render('proprete/show.html.twig', array(
                    'proprete' => $proprete,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Proprete entity.
     *
     * @Route("/edit-proprete/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Proprete $proprete) {
        $editForm = $this->createForm(new PropreteType(), $proprete);
        $editForm->handleRequest($request);
        $repositoryProprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Proprete");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $originalOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $othersOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        
        foreach ($operations as $operation) {
            if (!$proprete->getOperations()->contains($operation)) {
                $othersOperations->add($operation);
            }
        }
    
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idoperations = $request->request->get("idoperations");
                    foreach ($originalOperations as $operation) {
                        if (false === $proprete->getOperations()->contains($operation)) {
                            // remove the proprete from the produit
                            $operation->getPropretes()->removeElement($proprete);
                            $repositoryOperation->updateOperation($operation);
                        }
                    }

                    //add others exists operations to a proprete
                    if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                        foreach ($idoperations as $idoperation) {
                            $idoperation = (int) $idoperation;
                            $operation = $repositoryOperation->find($idoperation);
                            if (false === $proprete->getOperations()->contains($operation)) {
                                $proprete->getOperations()->add($operation);
                                $operation->getPropretes()->add($proprete);
                                $repositoryOperation->updateOperation($operation);
                            }
                        }
                    }
                    
                    $repositoryProprete->updateProprete($proprete);
                    $message = $this->get('translator')->trans('Proprete.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_propretes'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Proprete.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Propretes:form-update-proprete.html.twig', array('form' => $editForm->createView(), 'idproprete' => $proprete->getId(), 'operations' => $othersOperations));
                }
            }
            foreach ($proprete->getOperations() as $operation) {
                $originalOperations->add($operation);
            }
            return $this->render('NNGenieMaintenanceBundle:Propretes:form-update-proprete.html.twig', array('form' => $editForm->createView(), 'idproprete' => $proprete->getId(), 'operations' => $othersOperations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_propretes'));
        }
    }

    /**
     * Deletes a Proprete entity.
     *
     * @Route("/delete-proprete/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Proprete $proprete) {
        $request = $this->get("request");
        $repositoryProprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Proprete");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $produit = new Produit();
        $question = new Question();
        if ($request->isMethod('GET')) {
            try {
                foreach ($proprete->getProduits() as $produit) {
                    $produit->getPropretes()->removeElement($proprete);
                    $repositoryProduit->updateProduit($produit);
                }
                foreach ($proprete->getOperations() as $operation) {
                    $operation->getPropretes()->removeElement($proprete);
                    $repositoryOperation->updateProduit($produit);
                }
                $repositoryProprete->deleteProprete($proprete);
                $message = $this->get('translator')->trans('Proprete.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_propretes'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Proprete.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_propretes'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_propretes'));
        }
    }

}
