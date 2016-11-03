<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Controlematinal;
use NNGenie\MaintenanceBundle\Entity\Produit;
use NNGenie\MaintenanceBundle\Form\ControlematinalType;

/**
 * Controlematinal controller.
 *
 */
class ControlematinalController extends Controller {

    /**
     * @Route("/controles-matinaux")
     * @Template()
     */
    public function controlesmatinauxAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryControlematinal = $em->getRepository("NNGenieMaintenanceBundle:Controlematinal");
        $controlematinal = new Controlematinal();
        $form = $this->createForm(new ControlematinalType(), $controlematinal);
        //selectionne les seuls controlesmatinaux materiel actifs
        $controlesmatinaux = $repositoryControlematinal->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Controlesmatinaux:controlesmatinaux.html.twig', array('controlesmatinaux' => $controlesmatinaux, 'form' => $form->createView()));
    }

    /**
     * @Route("/controles-matinaux-user")
     * @Template()
     */
    public function controlesmatinauxuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryControlematinal = $em->getRepository("NNGenieMaintenanceBundle:Controlematinal");
        $controlematinal = new Controlematinal();
        $form = $this->createForm(new ControlematinalType(), $controlematinal);
        $display_tab = 1;
        //selectionne les seuls controlesmatinaux materiel actifs
        $controlesmatinaux = $repositoryControlematinal->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:controlematinal.html.twig', array('controlesmatinaux' => $controlesmatinaux, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Controlematinal entity.
     *
     * @Route("/new-controle-matinal")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $controlematinal = new Controlematinal();
        $controlematinalUnique = new Controlematinal();
        $form = $this->createForm(new ControlematinalType(), $controlematinal);
        $form->handleRequest($request);
        $repositoryControlematinal = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Controlematinal");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $produits = $repositoryProduit->findBy(array("statut" => 1));
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $controlematinalUnique = $repositoryControlematinal->findBy(array("nom" => $controlematinal->getNom(), "statut" => 1));
                if ($controlematinalUnique == null) {
                    try {
                        $idproduits = $request->request->get("idproduits");
                        $idoperations = $request->request->get("idoperations");
                        //add others exists produits to a controlematinal
                        if ($idproduits && is_array($idproduits) && !empty($idproduits)) {
                            foreach ($idproduits as $idproduit) {
                                $idproduit = (int) $idproduit;
                                $produit = $repositoryProduit->find($idproduit);
                                if (false === $controlematinal->getProduits()->contains($produit)) {
                                    $controlematinal->getProduits()->add($produit);
                                    $produit->getControlesmatinaux()->add($controlematinal);
                                    $repositoryProduit->updateProduit($produit);
                                }
                            }
                        }
                       
                        //add others exists operations to a controlematinal
                        if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                            foreach ($idoperations as $idoperation) {
                                $idoperation = (int) $idoperation;
                                $operation = $repositoryOperation->find($idoperation);
                                if (false === $controlematinal->getOperations()->contains($operation)) {
                                    $controlematinal->getOperations()->add($operation);
                                    $operation->getControlesmatinaux()->add($controlematinal);
                                    $repositoryOperation->updateOperation($operation);
                                }
                            }
                        }
                        $repositoryControlematinal->saveControlematinal($controlematinal);
                        $message = $this->get('translator')->trans('Controlematinal.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $controlematinal = new Controlematinal();
                        $form = $this->createForm(new ControlematinalType(), $controlematinal);
                        return $this->render('NNGenieMaintenanceBundle:Controlesmatinaux:form-add-controlematinal.html.twig', array('form' => $form->createView(), 'produits' => $produits, 'operations' => $operations));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Controlematinal.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Controlesmatinaux:form-add-controlematinal.html.twig', array('form' => $form->createView(), 'produits' => $produits, 'operations' => $operations));
                    }
                } else {
                    $message = $this->get('translator')->trans('Controlematinal.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Controlesmatinaux:form-add-controlematinal.html.twig', array('form' => $form->createView(), 'produits' => $produits, 'operations' => $operations));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Controlesmatinaux:form-add-controlematinal.html.twig', array('form' => $form->createView(), 'produits' => $produits, 'operations' => $operations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_controlesmatinaux'));
        }
    }

    /**
     * Finds and displays a Controlematinal entity.
     *
     * @Route("/show-controlematinal/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Controlematinal $controlematinal) {
        $deleteForm = $this->createDeleteForm($controlematinal);

        return $this->render('controlematinal/show.html.twig', array(
                    'controlematinal' => $controlematinal,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Controlematinal entity.
     *
     * @Route("/edit-controle-matinal/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Controlematinal $controlematinal) {
        $produit = new Produit();
        $editForm = $this->createForm(new ControlematinalType(), $controlematinal);
        $editForm->handleRequest($request);
        $repositoryControlematinal = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Controlematinal");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $originalProduits = new \Doctrine\Common\Collections\ArrayCollection();
        $originalOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $othersProduits = new \Doctrine\Common\Collections\ArrayCollection();
        $othersOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $produits = $repositoryProduit->findBy(array("statut" => 1));
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        foreach ($produits as $produit) {
            if (!$controlematinal->getProduits()->contains($produit)) {
                $othersProduits->add($produit);
            }
        }
        
        foreach ($operations as $operation) {
            if (!$controlematinal->getOperations()->contains($operation)) {
                $othersOperations->add($operation);
            }
        }
    
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idproduits = $request->request->get("idproduits");
                    $idoperations = $request->request->get("idoperations");
                    // remove the relationship between the tag and the Task
                    foreach ($originalProduits as $produit) {
                        if (false === $controlematinal->getProduits()->contains($produit)) {
                            // remove the controlematinal from the produit
                            $produit->getControlesmatinaux()->removeElement($controlematinal);

                            // if it was a many-to-one relationship, remove the relationship like this
                            // $produit->setControlematinal(null);

                            $repositoryProduit->updateProduit($produit);

                            // if you wanted to delete the Produit entirely, you can also do that
                            // $em->remove($produit);
                        }
                    }
                    //add others exists produits to a controlematinal
                    if ($idproduits && is_array($idproduits) && !empty($idproduits)) {
                        foreach ($idproduits as $idproduit) {
                            $idproduit = (int) $idproduit;
                            $produit = $repositoryProduit->find($idproduit);
                            if (false === $controlematinal->getProduits()->contains($produit)) {
                                $controlematinal->getProduits()->add($produit);
                                $produit->getControlesmatinaux()->add($controlematinal);
                                $repositoryProduit->updateProduit($produit);
                            }
                        }
                    }
                    
                    foreach ($originalOperations as $operation) {
                        if (false === $controlematinal->getOperations()->contains($operation)) {
                            // remove the controlematinal from the produit
                            $operation->getControlesmatinaux()->removeElement($controlematinal);
                            $repositoryOperation->updateOperation($operation);
                        }
                    }

                    //add others exists operations to a controlematinal
                    if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                        foreach ($idoperations as $idoperation) {
                            $idoperation = (int) $idoperation;
                            $operation = $repositoryOperation->find($idoperation);
                            if (false === $controlematinal->getOperations()->contains($operation)) {
                                $controlematinal->getOperations()->add($operation);
                                $operation->getControlesmatinaux()->add($controlematinal);
                                $repositoryOperation->updateOperation($operation);
                            }
                        }
                    }
                    $repositoryControlematinal->updateControlematinal($controlematinal);
                    $message = $this->get('translator')->trans('Controlematinal.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_controlesmatinaux'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Controlematinal.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Controlesmatinaux:form-update-controlematinal.html.twig', array('form' => $editForm->createView(), 'idcontrolematinal' => $controlematinal->getId(), 'produits' => $othersProduits, 'operations' => $othersOperations));
                }
            }
            foreach ($controlematinal->getProduits() as $produit) {
                $originalProduits->add($produit);
            }
            foreach ($controlematinal->getOperations() as $operation) {
                $originalOperations->add($operation);
            }
            return $this->render('NNGenieMaintenanceBundle:Controlesmatinaux:form-update-controlematinal.html.twig', array('form' => $editForm->createView(), 'idcontrolematinal' => $controlematinal->getId(), 'produits' => $othersProduits, 'operations' => $othersOperations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_controlesmatinaux'));
        }
    }

    /**
     * Deletes a Controlematinal entity.
     *
     * @Route("/delete-controle-matinal/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Controlematinal $controlematinal) {
        $request = $this->get("request");
        $repositoryControlematinal = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Controlematinal");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $produit = new Produit();
        if ($request->isMethod('GET')) {
            try {
                foreach ($controlematinal->getProduits() as $produit) {
                    $produit->getControlesmatinaux()->removeElement($controlematinal);
                    $repositoryProduit->updateProduit($produit);
                }
                foreach ($controlematinal->getOperations() as $operation) {
                    $operation->getControlesmatinaux()->removeElement($controlematinal);
                    $repositoryOperation->updateOperation($operation);
                }
                $repositoryControlematinal->deleteControlematinal($controlematinal);
                $message = $this->get('translator')->trans('Controlematinal.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_controlesmatinaux'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Controlematinal.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_controlesmatinaux'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_controlesmatinaux'));
        }
    }

}
