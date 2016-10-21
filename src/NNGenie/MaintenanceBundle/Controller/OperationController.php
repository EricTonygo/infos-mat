<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Operation;
use NNGenie\MaintenanceBundle\Entity\Produit;
use NNGenie\MaintenanceBundle\Form\OperationType;

/**
 * Operation controller.
 *
 */
class OperationController extends Controller {

    /**
     * @Route("/operations")
     * @Template()
     */
    public function operationsAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryOperation = $em->getRepository("NNGenieMaintenanceBundle:Operation");
        $operation = new Operation();
        $form = $this->createForm(new OperationType(), $operation);
        //selectionne les seuls operations materiel actifs
        $operations = $repositoryOperation->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Operations:operations.html.twig', array('operations' => $operations, 'form' => $form->createView()));
    }

    /**
     * @Route("/operations-user")
     * @Template()
     */
    public function operationsuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryOperation = $em->getRepository("NNGenieMaintenanceBundle:Operation");
        $operation = new Operation();
        $form = $this->createForm(new OperationType(), $operation);
        $display_tab = 1;
        //selectionne les seuls operations materiel actifs
        $operations = $repositoryOperation->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:operation.html.twig', array('operations' => $operations, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Operation entity.
     *
     * @Route("/new-operation")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $operation = new Operation();
        $produit = new Produit();
        $form = $this->createForm(new OperationType(), $operation);
        $form->handleRequest($request);
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $produits = $repositoryProduit->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $operationUnique = $repositoryOperation->findBy(array("nom" => $operation->getNom(), "statut" => 1));
                if ($operationUnique == null) {
                    try {
                        $idproduits = $request->request->get("idproduits");
                        if ($idproduits && is_array($idproduits) && !empty($idproduits)) {
                            foreach ($idproduits as $idproduit) {
                                $idproduit = (int) $idproduit;
                                $produit = $repositoryProduit->find($idproduit);
                                if (false === $operation->getProduits()->contains($produit)) {
                                    $operation->getProduits()->add($produit);
                                    $produit->getOperations()->add($operation);
                                    $repositoryProduit->updateProduit($produit);
                                }
                            }
                        }
                        $repositoryOperation->saveOperation($operation);
                        $message = $this->get('translator')->trans('Operation.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $operation = new Operation();
                        $form = $this->createForm(new OperationType(), $operation);
                        return $this->render('NNGenieMaintenanceBundle:Operations:form-add-operation.html.twig', array('form' => $form->createView(), 'produits' => $produits));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Operation.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Operations:form-add-operation.html.twig', array('form' => $form->createView(), 'produits' => $produits));
                    }
                } else {
                    $message = $this->get('translator')->trans('Operation.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Operations:form-add-operation.html.twig', array('form' => $form->createView(), 'produits' => $produits));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Operations:form-add-operation.html.twig', array('form' => $form->createView(), 'produits' => $produits));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_operations'));
        }
    }

    /**
     * Finds and displays a Operation entity.
     *
     * @Route("/show-operation/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Operation $operation) {
        $deleteForm = $this->createDeleteForm($operation);

        return $this->render('operation/show.html.twig', array(
                    'operation' => $operation,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Operation entity.
     *
     * @Route("/edit-operation/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Operation $operation) {
        $produit = new Produit();
        $editForm = $this->createForm(new OperationType(), $operation);
        $editForm->handleRequest($request);
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $othersProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $originalProduits = new \Doctrine\Common\Collections\ArrayCollection();
        $produits = $repositoryProduit->findBy(array("statut" => 1));
        foreach ($produits as $produit) {
            if (!$operation->getProduits()->contains($produit)) {
                $othersProducts->add($produit);
            }
        }
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idproduits = $request->request->get("idproduits");
                    // remove the relationship between the tag and the Task
                    foreach ($originalProduits as $produit) {
                        if (false === $operation->getProduits()->contains($produit)) {
                            // remove the operation from the produit
                            $produit->getOperations()->removeElement($operation);

                            // if it was a many-to-one relationship, remove the relationship like this
                            // $produit->setOperation(null);

                            $repositoryProduit->updateProduit($produit);

                            // if you wanted to delete the Produit entirely, you can also do that
                            // $em->remove($produit);
                        }
                    }
                    //add others exists produits to a operation
                    if ($idproduits && is_array($idproduits) && !empty($idproduits)) {
                        foreach ($idproduits as $idproduit) {
                            $idproduit = (int) $idproduit;
                            $produit = $repositoryProduit->find($idproduit);
                            if (false === $operation->getProduits()->contains($produit)) {
                                $operation->getProduits()->add($produit);
                                $produit->getOperations()->add($operation);
                                $repositoryProduit->updateProduit($produit);
                            }
                        }
                    }
                    $repositoryOperation->updateOperation($operation);
                    $message = $this->get('translator')->trans('Operation.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_operations'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Operation.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Operations:form-update-operation.html.twig', array('form' => $editForm->createView(), 'idoperation' => $operation->getId(), 'produits' => $othersProducts));
                }
            }
            foreach ($operation->getProduits() as $produit) {
                $originalProduits->add($produit);
            }
            return $this->render('NNGenieMaintenanceBundle:Operations:form-update-operation.html.twig', array('form' => $editForm->createView(), 'idoperation' => $operation->getId(), 'produits' => $othersProducts));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_operations'));
        }
    }

    /**
     * Deletes a Operation entity.
     *
     * @Route("/delete-operation/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Operation $operation) {
        $request = $this->get("request");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $produit = new Produit();
        if ($request->isMethod('GET')) {
            try {
                foreach ($operation->getProduits() as $produit) {
                    $produit->getOperations()->removeElement($operation);
                    $repositoryProduit->updateProduit($produit);
                }
                $repositoryOperation->deleteOperation($operation);
                $message = $this->get('translator')->trans('Operation.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_operations'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Operation.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_operations'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_operations'));
        }
    }

}
