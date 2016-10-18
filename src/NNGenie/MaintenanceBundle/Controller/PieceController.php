<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\MaintenanceBundle\Entity\Piece;
use NNGenie\MaintenanceBundle\Form\PieceType;

/**
 * Piece controller.
 *
 */
class PieceController extends Controller {

    /**
     * @Route("/pieces")
     * @Template()
     */
    public function piecesAction() {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryPiece = $em->getRepository("NNGenieMaintenanceBundle:Piece");
        $piece = new Piece();
        $form = $this->createForm(new PieceType(), $piece);
        //selectionne les seuls pieces materiel actifs
        $pieces = $repositoryPiece->findBy(array("statut" => 1));

        return $this->render('NNGenieMaintenanceBundle:Pieces:pieces.html.twig', array('pieces' => $pieces, 'form' => $form->createView()));
    }

    /**
     * Creates a new Piece entity.
     *
     * @Route("/new-piece")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $piece = new Piece();
        $pieceUnique = new Piece();
        $form = $this->createForm(new PieceType(), $piece);
        $form->handleRequest($request);
        $repositoryPiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Piece");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $pieceUnique = $repositoryPiece->findBy(array("nom" => $piece->getNom(), "statut" => 1));
                if ($pieceUnique == null) {
                    try {
                        $repositoryPiece->savePiece($piece);
                        $message = $this->get('translator')->trans('Piece.created_success', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $piece = new Piece();
                        $form = $this->createForm(new PieceType(), $piece);
                        return $this->render('NNGenieMaintenanceBundle:Pieces:form-add-piece.html.twig', array('form' => $form->createView()));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Piece.created_failure', array(), "NNGenieMaintenanceBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                        return $this->render('NNGenieMaintenanceBundle:Pieces:form-add-piece.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Piece.exist_already', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Pieces:form-add-piece.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Pieces:form-add-piece.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_piecess'));
        }
    }

    /**
     * Finds and displays a Piece entity.
     *
     * @Route("/show-piece/{id}", name="post_admin_show")
     * @Method({"GET"})
     */
    public function showAction(Piece $piece) {
        $deleteForm = $this->createDeleteForm($piece);

        return $this->render('piece/show.html.twig', array(
                    'piece' => $piece,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Piece entity.
     *
     * @Route("/edit-piece/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Piece $piece) {
        // $deleteForm = $this->createDeleteForm($piece);
        $editForm = $this->createForm(new PieceType(), $piece);
        $editForm->handleRequest($request);
        $repositoryPiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Piece");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryPiece->updatePiece($piece);
                    $message = $this->get('translator')->trans('Piece.updated_success', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_maintenance_pieces'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Piece.updated_failure', array(), "NNGenieMaintenanceBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieMaintenanceBundle:Pieces:form-update-piece.html.twig', array('form' => $editForm->createView(), 'idpiece' => $piece->getId()));
                }
            }
            return $this->render('NNGenieMaintenanceBundle:Pieces:form-update-piece.html.twig', array('form' => $editForm->createView(), 'idpiece' => $piece->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_pieces'));
        }
    }

    /**
     * Deletes a Piece entity.
     *
     * @Route("/delete-piece/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Piece $piece) {
        $request = $this->get("request");
        $repositoryPiece = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Piece");
        if ($request->isMethod('GET')) {
            try {
                $repositoryPiece->deletePiece($piece);
                $message = $this->get('translator')->trans('Piece.deleted_success', array(), "NNGenieMaintenanceBundle");
               $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_pieces'));
            } catch (Exception $ex) {
                $message = $this->get('translator')->trans('Piece.updated_failure', array(), "NNGenieMaintenanceBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_maintenance_pieces'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_maintenance_pieces'));
        }
    }

}