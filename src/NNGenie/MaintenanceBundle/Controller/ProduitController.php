<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Produit;
use NNGenie\MaintenanceBundle\Form\ProduitType;
use NNGenie\MaintenanceBundle\Entity\Operation;

/**
 * Produit controller.
 *
 */
class ProduitController extends Controller {

    /**
     * @Route("/produits")
     * @Template()
     */
    public function produitsAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryProduit = $em->getRepository("NNGenieMaintenanceBundle:Produit");
        $produit = new Produit();
        $form = $this->createForm(new ProduitType(), $produit);
        //selectionne les seuls produits materiel actifs
        $produits = $repositoryProduit->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Produits:produits.html.twig', array('produits' => $produits, 'form' => $form->createView()));
    }

    /**
     * Creates a new Produit entity.
     *
     * @Route("/new-produit")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $produit = new Produit();
        $produitUnique = new Produit();
        $form = $this->createForm(new ProduitType(), $produit);
        $form->handleRequest($request);
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $produitUnique = $repositoryProduit->findBy(array("nom" => $produit->getNom(), "statut" => 1));
                if ($produitUnique == null) {
                    try {
                        $repositoryProduit->saveProduit($produit);
                        $message = $this->get('translator')->trans('Produit.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $produit = new Produit();
                        $form = $this->createForm(new ProduitType(), $produit);
                        return $this->render('NNGenieMaintenanceBundle:Produits:form-add-produit.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Produit.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Produits:form-add-produit.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Produit.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Produits:form-add-produit.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Produits:form-add-produit.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_produitss'));
        }
    }

    /**
     * Finds and displays a Produit entity.
     *
     * @Route("/show-produit/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Produit $produit) {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('produit/show.html.twig', array(
                    'produit' => $produit,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Produit entity.
     *
     * @Route("/edit-produit/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Produit $produit) {
        // $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm(new ProduitType(), $produit);
        $editForm->handleRequest($request);
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryProduit->updateProduit($produit);
                    $message = $this->get('translator')->trans('Produit.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_produits'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Produit.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Produits:form-update-produit.html.twig', array('form' => $editForm->createView(), 'idproduit' => $produit->getId()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Produits:form-update-produit.html.twig', array('form' => $editForm->createView(), 'idproduit' => $produit->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_produits'));
        }
    }

    /**
     * Deletes a Produit entity.
     *
     * @Route("/delete-produit/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Produit $produit) {
        $request = $this->get("request");
        $operation = new Operation();
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit"); 
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation"); 
        if ($request->isMethod('GET')) {
            try {
                foreach ($produit->getOperations() as $operation){
                    $operation->getProduits()->removeElement($produit);
                    $repositoryOperation->updateOperation($operation);
                }
                $repositoryProduit->deleteProduit($produit);
                $message = $this->get('translator')->trans('Produit.deleted_success', array(), "NNGenieMaintenanceBundle");
               $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_produits'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Produit.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_produits'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_produits'));
        }
    }

}