<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Fournisseurpiece;
use NNGenie\InfosMatBundle\Entity\Type;
use NNGenie\MaintenanceBundle\Form\FournisseurpieceType;

/**
 * Fournisseurpiece controller.
 *
 */
class FournisseurpieceController extends Controller {

    /**
     * @Route("/fournisseurs-pieces")
     * @Template()
     */
    public function fournisseurspiecesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryFournisseurpiece = $em->getRepository("NNGenieMaintenanceBundle:Fournisseurpiece");
        $fournisseurpiece = new Fournisseurpiece();
        $form = $this->createForm(new FournisseurpieceType(), $fournisseurpiece);
        //selectionne les seuls fournisseurpieces materiel actifs
        $fournisseurspieces = $repositoryFournisseurpiece->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Fournisseurspieces:fournisseurspieces.html.twig', array('fournisseurspieces' => $fournisseurspieces, 'form' => $form->createView()));
    }

    /**
     * @Route("/fournisseurs-pieces-user")
     * @Template()
     */
    public function fournisseurpiecesuserAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryFournisseurpiece = $em->getRepository("NNGenieMaintenanceBundle:Fournisseurpiece");
        $fournisseurpiece = new Fournisseurpiece();
        $form = $this->createForm(new FournisseurpieceType(), $fournisseurpiece);
        $display_tab = 1;
        //selectionne les seuls fournisseurpieces materiel actifs
        $fournisseurspieces = $repositoryFournisseurpiece->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:FrontEnd:fournisseurspiece.html.twig', array('fournisseurspieces' => $fournisseurspieces, 'form' => $form->createView(), "display_tab" => $display_tab));
    }

    /**
     * Creates a new Fournisseurpiece entity.
     *
     * @Route("/new-fournisseur-piece")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $fournisseurpiece = new Fournisseurpiece();
        $type = new Type();
        $form = $this->createForm(new FournisseurpieceType(), $fournisseurpiece);
        $form->handleRequest($request);
        $repositoryFournisseurpiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Fournisseurpiece");
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");
        $types = $repositoryType->findBy(array("statut" => 1));
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $fournisseurpieceUnique = $repositoryFournisseurpiece->findBy(array("nom" => $fournisseurpiece->getNom(), "statut" => 1));
                if ($fournisseurpieceUnique == null) {
                    try {
                        $idtypes = $request->request->get("idtypes");
                        if ($idtypes && is_array($idtypes) && !empty($idtypes)) {
                            foreach ($idtypes as $idtype) {
                                $idtype = (int) $idtype;
                                $type = $repositoryType->find($idtype);
                                if (false === $fournisseurpiece->getTypes()->contains($type)) {
                                    $fournisseurpiece->getTypes()->add($type);
                                    $type->getFournisseurpieces()->add($fournisseurpiece);
                                    $repositoryType->updateType($type);
                                }
                            }
                        }
                        $repositoryFournisseurpiece->saveFournisseurpiece($fournisseurpiece);
                        $message = $this->get('translator')->trans('Fournisseurpiece.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $fournisseurpiece = new Fournisseurpiece();
                        $form = $this->createForm(new FournisseurpieceType(), $fournisseurpiece);
                        return $this->render('NNGenieMaintenanceBundle:Fournisseurspieces:form-add-fournisseurpiece.html.twig', array('form' => $form->createView(), 'types' => $types));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Fournisseurpiece.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Fournisseurspieces:form-add-fournisseurpiece.html.twig', array('form' => $form->createView(), 'types' => $types));
                    }
                } else {
                    $message = $this->get('translator')->trans('Fournisseurpiece.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Fournisseurspieces:form-add-fournisseurpiece.html.twig', array('form' => $form->createView(), 'types' => $types));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Fournisseurspieces:form-add-fournisseurpiece.html.twig', array('form' => $form->createView(), 'types' => $types));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_fournisseurspieces'));
        }
    }

    /**
     * Finds and displays a Fournisseurpiece entity.
     *
     * @Route("/show-fournisseurpiece/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Fournisseurpiece $fournisseurpiece) {
        $deleteForm = $this->createDeleteForm($fournisseurpiece);

        return $this->render('fournisseurpiece/show.html.twig', array(
                    'fournisseurpiece' => $fournisseurpiece,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fournisseurpiece entity.
     *
     * @Route("/edit-fournisseur-piece/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Fournisseurpiece $fournisseurpiece) {
        $type = new Type();
        $editForm = $this->createForm(new FournisseurpieceType(), $fournisseurpiece);
        $editForm->handleRequest($request);
        $repositoryFournisseurpiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Fournisseurpiece");
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");
        $othersProducts = new \Doctrine\Common\Collections\ArrayCollection();
        $originalTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $types = $repositoryType->findBy(array("statut" => 1));
        foreach ($types as $type) {
            if (!$fournisseurpiece->getTypes()->contains($type)) {
                $othersProducts->add($type);
            }
        }
        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $idtypes = $request->request->get("idtypes");
                    // remove the relationship between the tag and the Task
                    foreach ($originalTypes as $type) {
                        if (false === $fournisseurpiece->getTypes()->contains($type)) {
                            // remove the fournisseurpiece from the type
                            $type->getFournisseurpieces()->removeElement($fournisseurpiece);

                            // if it was a many-to-one relationship, remove the relationship like this
                            // $type->setFournisseurpiece(null);

                            $repositoryType->updateType($type);

                            // if you wanted to delete the Type entirely, you can also do that
                            // $em->remove($type);
                        }
                    }
                    //add others exists types to a fournisseurpiece
                    if ($idtypes && is_array($idtypes) && !empty($idtypes)) {
                        foreach ($idtypes as $idtype) {
                            $idtype = (int) $idtype;
                            $type = $repositoryType->find($idtype);
                            if (false === $fournisseurpiece->getTypes()->contains($type)) {
                                $fournisseurpiece->getTypes()->add($type);
                                $type->getFournisseurpieces()->add($fournisseurpiece);
                                $repositoryType->updateType($type);
                            }
                        }
                    }
                    $repositoryFournisseurpiece->updateFournisseurpiece($fournisseurpiece);
                    $message = $this->get('translator')->trans('Fournisseurpiece.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_fournisseurspieces'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Fournisseurpiece.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Fournisseurspieces:form-update-fournisseurpiece.html.twig', array('form' => $editForm->createView(), 'idfournisseurpiece' => $fournisseurpiece->getId(), 'types' => $othersProducts));
                }
            }
            foreach ($fournisseurpiece->getTypes() as $type) {
                $originalTypes->add($type);
            }
            return $this->render('NNGenieMaintenanceBundle:Fournisseurspieces:form-update-fournisseurpiece.html.twig', array('form' => $editForm->createView(), 'idfournisseurpiece' => $fournisseurpiece->getId(), 'types' => $othersProducts));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_fournisseurspieces'));
        }
    }

    /**
     * Deletes a Fournisseurpiece entity.
     *
     * @Route("/delete-fournisseur-piece/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Fournisseurpiece $fournisseurpiece) {
        $request = $this->get("request");
        $repositoryFournisseurpiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Fournisseurpiece");
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");
        $type = new Type();
        if ($request->isMethod('GET')) {
            try {
                foreach ($fournisseurpiece->getTypes() as $type) {
                    $type->getFournisseurpieces()->removeElement($fournisseurpiece);
                    $repositoryType->updateType($type);
                }
                $repositoryFournisseurpiece->deleteFournisseurpiece($fournisseurpiece);
                $message = $this->get('translator')->trans('Fournisseurpiece.deleted_success', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_fournisseurspieces'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Fournisseurpiece.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_fournisseurspieces'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_fournisseurspieces'));
        }
    }

}
