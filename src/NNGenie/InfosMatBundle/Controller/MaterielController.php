<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Materiel;
use NNGenie\InfosMatBundle\Form\MaterielType;

/**
 * Materiel controller.
 *
 */
class MaterielController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function accueilAction() {
        return $this->render('NNGenieInfosMatBundle:Administration:index.html.twig');
    }
    
    /**
     * @Route("/filtre-materiels")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function filtrematerielsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $idgrenres = $request->request->get("genres");
        $idmarques = $request->request->get("marques");
        $idtypes = $request->request->get("types");
        $idlocalisations = $request->request->get("localisations");
        $idproprietaires = $request->request->get("proprietaires");
        $em = $this->getDoctrine()->getManager();

        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
        $repositoryMarque = $em->getRepository("NNGenieInfosMatBundle:Marque");
        $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
        $repositoryLocalisation = $em->getRepository("NNGenieInfosMatBundle:Localisation");
        $repositoryProprietaire = $em->getRepository("NNGenieInfosMatBundle:Proprietaire");
        //selectionne les seuls materiels actifs
        $materiels = $repositoryMateriel->filtreMaterielBy($idgrenres);
        $genres = $repositoryGenre->findBy(array("statut" => 1));
        $marques = $repositoryMarque->findBy(array("statut" => 1));
        $types = $repositoryType->findBy(array("statut" => 1));
        $localisations = $repositoryLocalisation->findBy(array("statut" => 1));
        $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'genres' => $genres, 'marques' => $marques, 'types' => $types, 'localisations' => $localisations, 'proprietaires' => $proprietaires,));
    }

    /**
     * @Route("/materiels")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function materielsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /* if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          } */
        $em = $this->getDoctrine()->getManager();

        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
        $repositoryMarque = $em->getRepository("NNGenieInfosMatBundle:Marque");
        $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
        $repositoryLocalisation = $em->getRepository("NNGenieInfosMatBundle:Localisation");
        $repositoryProprietaire = $em->getRepository("NNGenieInfosMatBundle:Proprietaire");
        //selectionne les seuls materiels actifs
        $materiels = $repositoryMateriel->findBy(array("statut" => 1));
        $genres = $repositoryGenre->findBy(array("statut" => 1));
        $marques = $repositoryMarque->findBy(array("statut" => 1));
        $types = $repositoryType->findBy(array("statut" => 1));
        $localisations = $repositoryLocalisation->findBy(array("statut" => 1));
        $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'genres' => $genres, 'marques' => $marques, 'types' => $types, 'localisations' => $localisations, 'proprietaires' => $proprietaires,));
    }

    /**
     * Creates a new Materiel entity.
     *
     * @Route("/new-materiel")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function newAction(Request $request) {
        $materiel = new Materiel();
        $materielUnique = new Materiel();
        $form = $this->createForm(new MaterielType(), $materiel);
        $form->handleRequest($request);
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($form->isSubmitted() && $form->isValid()) {
                $materielUnique = $repositoryMateriel->findBy(array("chassis" => $materiel->getChassis()));
                if ($materielUnique == null) {
                    try {
                        $repositoryMateriel->saveMateriel($materiel);
                        $message = $this->get('translator')->trans('Materiel.created_success', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message', $message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
                    } catch (Exception $ex) {
                        $message = $this->get('translator')->trans('Materiel.created_failure', array(), "NNGenieInfosMatBundle");
                        $request->getSession()->getFlashBag()->add('message_faillure', $message);
                        return $this->render('NNGenieInfosMatBundle:Materiels:form-add-materiel.html.twig', array('form' => $form->createView()));
                    }
                } else {
                    $message = $this->get('translator')->trans('Materiel.exist_already', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Materiels:form-add-materiel.html.twig', array('form' => $form->createView()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Materiels:form-add-materiel.html.twig', array('form' => $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Finds and displays a Materiel entity.
     *
     * @Route("/show-materiel/{id}", name="post_admin_show")
     * @Method("GET")
     */
    public function showAction(Materiel $materiel) {
        $deleteForm = $this->createDeleteForm($materiel);

        return $this->render('materiel/show.html.twig', array(
                    'materiel' => $materiel,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Materiel entity.
     *
     * @Route("/edit-materiel/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editAction(Request $request, Materiel $materiel) {
        // $deleteForm = $this->createDeleteForm($materiel);
        $editForm = $this->createForm(new MaterielType(), $materiel);
        $editForm->handleRequest($request);
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $repositoryMateriel->updateMateriel($materiel);
                    $message = $this->get('translator')->trans('Materiel.updated_success', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_success', $message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Materiel.updated_failure', array(), "NNGenieInfosMatBundle");
                    $request->getSession()->getFlashBag()->add('message_faillure', $message);
                    return $this->render('NNGenieInfosMatBundle:Materiels:form-update-materiel.html.twig', array('form' => $editForm->createView(), 'idmateriel' => $materiel->getId()));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Materiels:form-update-materiel.html.twig', array('form' => $editForm->createView(), 'idmateriel' => $materiel->getId()));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Deletes a Materiel entity.
     *
     * @Route("/delete-materiel/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function deleteAction(Materiel $materiel) {
        $request = $this->get("request");
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");
        if ($request->isMethod('GET')) {
            try {
                $repositoryMateriel->deleteMateriel($materiel);
                $message = $message = $this->get('translator')->trans('Materiel.deleted_success', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_success', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Materiel.deleted_failure', array(), "NNGenieInfosMatBundle");
                $request->getSession()->getFlashBag()->add('message_faillure', $message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Creates a form to delete a Materiel entity.
     *
     * @param Materiel $materiel The Materiel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Materiel $materiel) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('post_admin_delete', array('id' => $materiel->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
