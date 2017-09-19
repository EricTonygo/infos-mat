<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use NNGenie\InfosMatBundle\Entity\Materiel;
use NNGenie\InfosMatBundle\Entity\Genre;
use NNGenie\InfosMatBundle\Entity\Type;
use NNGenie\InfosMatBundle\Entity\Marque;
use NNGenie\InfosMatBundle\Form\MaterielType;
use NNGenie\InfosMatBundle\Form\MaterielMainImageType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Materiel controller.
 *
 */
class MaterielController extends Controller {

    /**
     * @Route("/accueil-admin")
     * @Template()
     */
    public function accueiladminAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");
        $userManager = $this->container->get('fos_user.user_manager');
        $repositoryFournisseur = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Fournisseur");
        $repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Proprietaire");
        $page = 1;
        $maxResults = 10;
        $route_param_page = array();
        $route_param_search_query = array();
        $search_query = null;

        if ($request->get('page')) {
            $page = intval(htmlspecialchars(trim($request->get('page'))));
            $route_param_page['page'] = $page;
        }
        if ($request->get('search_query')) {
            $search_query = htmlspecialchars(trim($request->get('search_query')));
            $route_param_search_query['search_query'] = $search_query;
        }
        $total_pages = ceil(count($repositoryMateriel->getMateriels($search_query)));
        $start_from = ($page - 1) * $maxResults >= 0 ? ($page - 1) * $maxResults : 0;
        $materiels = $repositoryMateriel->getMateriels($search_query);
        $users = $userManager->findUsers();
        $fournisseurs = $repositoryFournisseur->findBy(array("statut" => 1));
        $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));

        //return $this->render('NNGenieInfosMatBundle::index.html.twig', array("materiels"=> $materiels));
        return $this->render('NNGenieInfosMatBundle:Administration:index.html.twig', array('nombreUsers' => count($users), 'nombreMateriels' => count($materiels), 'nombreFounisseurs' => count($fournisseurs), 'nombreProprietaires' => count($proprietaires)));
    }

    /**
     * @Route("/filtre-materiels")
     * @Template()
     * @Method({"POST","GET"})
     * @param Request $request
     */
    public function filtrematerielsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        if ($request->isMethod("POST")) {
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
            $materiels = $repositoryMateriel->filtreMaterielBy($idgrenres, $idmarques, $idtypes, $idproprietaires, $idlocalisations);
            $genres = $repositoryGenre->findBy(array("statut" => 1));
            $marques = $repositoryMarque->findBy(array("statut" => 1));
            $types = $repositoryType->findBy(array("statut" => 1));
            $localisations = $repositoryLocalisation->findBy(array("statut" => 1));
            $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));

            return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('materiels' => $materiels, 'genres' => $genres, 'marques' => $marques, 'types' => $types, 'localisations' => $localisations, 'proprietaires' => $proprietaires,));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * @Route("/materiels")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function materielsAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
        $repositoryMarque = $em->getRepository("NNGenieInfosMatBundle:Marque");
        $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
        $repositoryLocalisation = $em->getRepository("NNGenieInfosMatBundle:Localisation");
        $repositoryProprietaire = $em->getRepository("NNGenieInfosMatBundle:Proprietaire");
        $page = 1;
        $maxResults = 10;
        $route_param_page = array();
        $route_param_search_query = array();
        $search_query = null;

        if ($request->get('page')) {
            $page = intval(htmlspecialchars(trim($request->get('page'))));
            $route_param_page['page'] = $page;
        }
        if ($request->get('search_query')) {
            $search_query = htmlspecialchars(trim($request->get('search_query')));
            $route_param_search_query['search_query'] = $search_query;
        }
        $total_pages = ceil(count($repositoryMateriel->getMateriels($search_query)) / $maxResults);
        $start_from = ($page - 1) * $maxResults >= 0 ? ($page - 1) * $maxResults : 0;
        $materiels = $repositoryMateriel->getMateriels($start_from, $maxResults, $search_query);
        $start = 1;
        $end = 1;
        if ($total_pages > 1) {
            $start = 1;
            $end = $total_pages;
            if ($total_pages > 5 && $page > 3) {
                $end = $page + 2 < $total_pages ? $page + 2 : $total_pages;
                $start = $end - 4 > 1 ? $end - 4 : 1;
            } elseif ($page > 5) {
                $end = 5;
            }
        }
        $genres = $repositoryGenre->findBy(array("statut" => 1));
        $marques = $repositoryMarque->findBy(array("statut" => 1));
        $types = $repositoryType->findBy(array("statut" => 1));
        $localisations = $repositoryLocalisation->findBy(array("statut" => 1));
        $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:Materiels:materiels.html.twig', array('total_pages' => $total_pages, 'page' => $page, 'end' => $end, 'start' => $start, 'route_param_page' => $route_param_page, 'route_param_search_query' => $route_param_search_query, 'materiels' => $materiels, 'genres' => $genres, 'marques' => $marques, 'types' => $types, 'localisations' => $localisations, 'proprietaires' => $proprietaires));
    }

    /**
     * @Route("/situation-generale")
     * @Template()
     * @Method({"GET"})
     * @param Request $request
     */
    public function materielsuserAction(Request $request) {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();

        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
        $repositoryMarque = $em->getRepository("NNGenieInfosMatBundle:Marque");
        $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
        $repositoryLocalisation = $em->getRepository("NNGenieInfosMatBundle:Localisation");
        $repositoryProprietaire = $em->getRepository("NNGenieInfosMatBundle:Proprietaire");
        $page = 1;
        $maxResults = 10;
        $route_param_page = array();
        $route_param_search_query = array();
        $search_query = null;

        if ($request->get('page')) {
            $page = intval(htmlspecialchars(trim($request->get('page'))));
            $route_param_page['page'] = $page;
        }
        if ($request->get('search_query')) {
            $search_query = htmlspecialchars(trim($request->get('search_query')));
            $route_param_search_query['search_query'] = $search_query;
        }
        $total_pages = ceil(count($repositoryMateriel->getMateriels($search_query)) / $maxResults);
        $start_from = ($page - 1) * $maxResults >= 0 ? ($page - 1) * $maxResults : 0;
        $materiels = $repositoryMateriel->getMateriels($start_from, $maxResults, $search_query);
        $genres = $repositoryGenre->findBy(array("statut" => 1));
        $marques = $repositoryMarque->findBy(array("statut" => 1));
        $types = $repositoryType->findBy(array("statut" => 1));
        $localisations = $repositoryLocalisation->findBy(array("statut" => 1));
        $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));

        return $this->render('NNGenieInfosMatBundle:FrontEnd:materiels.html.twig', array('total_pages' => $total_pages, 'page' => $page, 'route_param_page' => $route_param_page, 'route_param_search_query' => $route_param_search_query, 'materiels' => $materiels, 'genres' => $genres, 'marques' => $marques, 'types' => $types, 'localisations' => $localisations, 'proprietaires' => $proprietaires));
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
                try {
                    $materielUnique = $repositoryMateriel->findOneBy(array("chassis" => $materiel->getChassis(), "statut" => 1));
                    if ($materielUnique == null) {
                        $repositoryMateriel->saveMateriel($materiel);
                        $message = $this->get('translator')->trans('Materiel.created_success', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        $materiel = new Materiel();
                        $form = $this->createForm(new MaterielType(), $materiel);
                    } else {
                        $message = $this->get('translator')->trans('Materiel.exist_already', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    }
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Materiel.created_failure', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
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
                    $materielUnique = $repositoryMateriel->findOneBy(array("chassis" => $materiel->getChassis(), "statut" => 1));
                    if ($materielUnique && $materielUnique->getId() != $materiel->getId()) {
                        $message = $this->get('translator')->trans('Materiel.exist_already', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    } else {
                        $materiel->setDatemodification(new \Datetime());
                        $repositoryMateriel->updateMateriel($materiel);
                        $message = $this->get('translator')->trans('Materiel.updated_success', array(), "NNGenieInfosMatBundle");
                        $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                        return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
                    }
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Materiel.updated_failure', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                }
            }
            return $this->render('NNGenieInfosMatBundle:Materiels:form-update-materiel.html.twig', array('form' => $editForm->createView(), 'materiel' => $materiel));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Displays a form to edit an existing Materiel entity.
     *
     * @Route("/edit-main-image/{id}")
     * @Template()
     * @Method({"POST", "GET"})
     * @param Request $request
     */
    public function editMainImageAction(Request $request, Materiel $materiel) {
        // $deleteForm = $this->createDeleteForm($materiel);
        $editForm = $this->createForm(new MaterielMainImageType(), $materiel);
        $editForm->handleRequest($request);
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");

        if ($request->isMethod("POST") || $request->isMethod("GET")) {
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                try {
                    $materiel->setDatemodification(new \Datetime());
                    $repositoryMateriel->updateMateriel($materiel);
                    $message = $this->get('translator')->trans('Materiel.updated_success', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                    return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array('id' => $materiel->getId())));
                } catch (Exception $ex) {
                    $message = $this->get('translator')->trans('Materiel.updated_failure', array(), "NNGenieInfosMatBundle");
                    $this->get('ras_flash_alert.alert_reporter')->addError($message);
                    return $this->render('NNGenieInfosMatBundle:Materiels:form-update-main-image-materiel.html.twig', array('form' => $editForm->createView(), 'materiel' => $materiel));
                }
            }
            return $this->render('NNGenieInfosMatBundle:Materiels:form-update-main-image-materiel.html.twig', array('form' => $editForm->createView(), 'materiel' => $materiel));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiel_detail', array('id' => $materiel->getId())));
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
                $this->get('ras_flash_alert.alert_reporter')->addSuccess($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
            } catch (Exception $ex) {
                $message = $message = $this->get('translator')->trans('Materiel.deleted_failure', array(), "NNGenieInfosMatBundle");
                $this->get('ras_flash_alert.alert_reporter')->addError($message);
                return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
            }
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Type of Genre entity.
     *
     * @Route("/get-types-of-genre/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function getTypesOfGenreAction(Genre $genre) {
        $request = $this->get("request");
        if ($request->isXmlHttpRequest()) {
            try {
                $listeMarques = $genre->getMarques();
                $marque = new Marque();
                $type = new Type();
                $typesGenre = array();
                foreach ($listeMarques as $marque) {
                    $listeTypes = $marque->getTypes();
                    foreach ($listeTypes as $type) {
                        $typesGenre[] = array("id" => $type->getId(), "nom" => $type->getNom());
                    }
                }
                $response = new JsonResponse();
                return $response->setData(array("donnees" => $typesGenre));
            } catch (Exception $ex) {
                throw new \Exception("Erreur");
            }
        } else {
            throw new \Exception("Erreur");
        }
    }

    /**
     * Deletes a Materiel entity.
     *
     * @Route("/detail-materiel/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function detailAction(Materiel $materiel) {
        $request = $this->get("request");
        $em = $this->getDoctrine()->getManager();
        $repositoryImage = $em->getRepository("NNGenieInfosMatBundle:Image");
        $repositoryDonneetechniquetype = $em->getRepository("NNGenieInfosMatBundle:Donneetechniquetype");
        if ($request->isMethod('GET')) {
            $images = $repositoryImage->findBy(array('materiel' => $materiel, 'statut' => 1));
            $donneetechniques = $repositoryDonneetechniquetype->findBy(array('type' => $materiel->getType(), 'statut' => 1));
            return $this->render('NNGenieInfosMatBundle:Materiels:details-materiel.html.twig', array('materiel' => $materiel, 'images' => $images, 'donneetechniquetypes' => $donneetechniques));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels'));
        }
    }

    /**
     * Deletes a Materiel entity.
     *
     * @Route("/vue-materiel/{id}")
     * @Template()
     * @Method({"GET"})
     */
    public function detailuserAction(Materiel $materiel) {
        $request = $this->get("request");
        $em = $this->getDoctrine()->getManager();
        $repositoryImage = $em->getRepository("NNGenieInfosMatBundle:Image");
        if ($request->isMethod('GET')) {
            $images = $repositoryImage->findBy(array('materiel' => $materiel, 'statut' => 1));
            return $this->render('NNGenieInfosMatBundle:FrontEnd:details-materiel.html.twig', array('materiel' => $materiel, 'images' => $images));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_materiels_user'));
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
