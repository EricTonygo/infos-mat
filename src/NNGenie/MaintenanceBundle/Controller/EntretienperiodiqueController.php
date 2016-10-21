<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Entretienperiodique;
use NNGenie\MaintenanceBundle\Entity\Produit;
use NNGenie\MaintenanceBundle\Form\EntretienperiodiqueType;

/**
 * Entretienperiodique controller.
 *
 */
class EntretienperiodiqueController extends Controller {

    /**
     * @Route("/entretiens-periodiques")
     * @Template()
     */
    public function entretiensperiodiquesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryEntretienperiodique = $em->getRepository("NNGenieMaintenanceBundle:Entretienperiodique");
        $entretienperiodique = new Entretienperiodique();
        $form = $this->createForm(new EntretienperiodiqueType(), $entretienperiodique);
        //selectionne les seuls entretiensperiodiques materiel actifs
        $entretiensperiodiques = $repositoryEntretienperiodique->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Entretiensperiodiques:entretiensperiodiques.html.twig', array('entretiensperiodiques' => $entretiensperiodiques, 'form' => $form->createView()));
    }

    /**
     * @Route("/entretiensperiodiques-user")
     * @Template()
     */
    public function entretiensperiodiquesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryEntretienperiodique = $em->getRepository("NNGenieMaintenanceBundle:Entretienperiodique");
        $entretienperiodique = new Entretienperiodique();
        $form = $this->createForm(new EntretienperiodiqueType(), $entretienperiodique);
        $display_tab = 1;
        //selectionne les seuls entretiensperiodiques materiel actifs
        $entretiensperiodiques = $repositoryEntretienperiodique->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:entretienperiodique.html.twig', array('entretiensperiodiques' => $entretiensperiodiques, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Entretienperiodique entity.
     *
     * @Route("/new-entretien-perioque")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $entretienperiodique = new Entretienperiodique();
        $entretienperiodiqueUnique = new Entretienperiodique();
        $form = $this->createForm(new EntretienperiodiqueType(), $entretienperiodique);
        $form->handleRequest($request);
        $repositoryEntretienperiodique = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Entretienperiodique");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $entretienperiodiqueUnique = $repositoryEntretienperiodique->findBy(array("nom" => $entretienperiodique->getNom(), "statut" => 1));
                if ($entretienperiodiqueUnique == null) {
                    try {
                        $idoperations = $request->request->get("idoperations");
                        //add others exists operations to a entretienperiodique
                        if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                            foreach ($idoperations as $idoperation) {
                                $idoperation = (int) $idoperation;
                                $operation = $repositoryOperation->find($idoperation);
                                if (false === $entretienperiodique->getOperations()->contains($operation)) {
                                    $entretienperiodique->getOperations()->add($operation);
                                    $operation->getEntretiensperiodiques()->add($entretienperiodique);
                                    $repositoryOperation->updateOperation($operation);
                                }
                            }
                        }
                        $repositoryEntretienperiodique->saveEntretienperiodique($entretienperiodique);
                        $message = $this->get('translator')->trans('Entretienperiodique.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $entretienperiodique = new Entretienperiodique();
                        $form = $this->createForm(new EntretienperiodiqueType(), $entretienperiodique);
                        return $this->render('NNGenieMaintenanceBundle:Entretiensperiodiques:form-add-entretienperiodique.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Entretienperiodique.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Entretiensperiodiques:form-add-entretienperiodique.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                    }
                } else {
                    $message = $this->get('translator')->trans('Entretienperiodique.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Entretiensperiodiques:form-add-entretienperiodique.html.twig', array('form' => $form->createView(), 'operations' => $operations));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Entretiensperiodiques:form-add-entretienperiodique.html.twig', array('form' => $form->createView(), 'operations' => $operations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_entretiensperiodiques'));
        }
    }

    /**
     * Finds and displays a Entretienperiodique entity.
     *
     * @Route("/show-entretienperiodique/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Entretienperiodique $entretienperiodique) {
        $deleteForm = $this->createDeleteForm($entretienperiodique);

        return $this->render('entretienperiodique/show.html.twig', array(
                    'entretienperiodique' => $entretienperiodique,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Entretienperiodique entity.
     *
     * @Route("/edit-entretien-perioque/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Entretienperiodique $entretienperiodique) {
        $editForm = $this->createForm(new EntretienperiodiqueType(), $entretienperiodique);
        $editForm->handleRequest($request);
        $repositoryEntretienperiodique = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Entretienperiodique");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $originalOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $othersOperations = new \Doctrine\Common\Collections\ArrayCollection();
        $operations = $repositoryOperation->findBy(array("statut" => 1));
        
        foreach ($operations as $operation) {
            if (!$entretienperiodique->getOperations()->contains($operation)) {
                $othersOperations->add($operation);
            }
        }
    
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idoperations = $request->request->get("idoperations");
                    foreach ($originalOperations as $operation) {
                        if (false === $entretienperiodique->getOperations()->contains($operation)) {
                            // remove the entretienperiodique from the produit
                            $operation->getEntretiensperiodiques()->removeElement($entretienperiodique);
                            $repositoryOperation->updateOperation($operation);
                        }
                    }

                    //add others exists operations to a entretienperiodique
                    if ($idoperations && is_array($idoperations) && !empty($idoperations)) {
                        foreach ($idoperations as $idoperation) {
                            $idoperation = (int) $idoperation;
                            $operation = $repositoryOperation->find($idoperation);
                            if (false === $entretienperiodique->getOperations()->contains($operation)) {
                                $entretienperiodique->getOperations()->add($operation);
                                $operation->getEntretiensperiodiques()->add($entretienperiodique);
                                $repositoryOperation->updateOperation($operation);
                            }
                        }
                    }
                    
                    $repositoryEntretienperiodique->updateEntretienperiodique($entretienperiodique);
                    $message = $this->get('translator')->trans('Entretienperiodique.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_entretiensperiodiques'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Entretienperiodique.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Entretiensperiodiques:form-update-entretienperiodique.html.twig', array('form' => $editForm->createView(), 'identretienperiodique' => $entretienperiodique->getId(), 'operations' => $othersOperations));
                }
            }
            foreach ($entretienperiodique->getOperations() as $operation) {
                $originalOperations->add($operation);
            }
            return $this->render('NNGenieMaintenanceBundle:Entretiensperiodiques:form-update-entretienperiodique.html.twig', array('form' => $editForm->createView(), 'identretienperiodique' => $entretienperiodique->getId(), 'operations' => $othersOperations));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_entretiensperiodiques'));
        }
    }

    /**
     * Deletes a Entretienperiodique entity.
     *
     * @Route("/delete-entretien-perioque/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Entretienperiodique $entretienperiodique) {
        $request = $this->get("request");
        $repositoryEntretienperiodique = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Entretienperiodique");
        $repositoryProduit = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Produit");
        $repositoryOperation = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Operation");
        $produit = new Produit();
        $question = new Question();
        if ($request->isMethod('GET')) {
            try {
                foreach ($entretienperiodique->getProduits() as $produit) {
                    $produit->getEntretiensperiodiques()->removeElement($entretienperiodique);
                    $repositoryProduit->updateProduit($produit);
                }
                foreach ($entretienperiodique->getOperations() as $operation) {
                    $operation->getEntretiensperiodiques()->removeElement($entretienperiodique);
                    $repositoryOperation->updateProduit($produit);
                }
                $repositoryEntretienperiodique->deleteEntretienperiodique($entretienperiodique);
                $message = $this->get('translator')->trans('Entretienperiodique.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_entretiensperiodiques'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Entretienperiodique.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_entretiensperiodiques'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_entretiensperiodiques'));
        }
    }

}
