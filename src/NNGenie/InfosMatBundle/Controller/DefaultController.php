<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
       $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");
        $userManager = $this->container->get('fos_user.user_manager');
        $materiels = $repositoryMateriel->findBy(array("statut" => 1));
        $users = $userManager->findUsers();
        return $this->render('NNGenieInfosMatBundle:FrontEnd:index.html.twig', array('nombreUsers' => count($users), 'nombreMateriels' => count($materiels)));
    }
    
    
    /**
     * @Route("/view-materiels")
     * @Template()
     */
    public function viewmaterielsAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");
        $userManager = $this->container->get('fos_user.user_manager');
        $materiels = $repositoryMateriel->findBy(array("statut" => 1));
        $users = $userManager->findUsers();
        return $this->render('NNGenieInfosMatBundle:FrontEnd:view.materiels.accueil.html.twig', array('nombreUsers' => count($users), 'nombreMateriels' => count($materiels)));
    }
    
    /**
     * @Route("/ask-informations")
     * @Template()
     */
    public function askinformationsAction() {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
        $repositoryMarque = $em->getRepository("NNGenieInfosMatBundle:Marque");
        $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
        $repositoryLocalisation = $em->getRepository("NNGenieInfosMatBundle:Localisation");
        $repositoryProprietaire = $em->getRepository("NNGenieInfosMatBundle:Proprietaire");
        $repositoryEtat = $em->getRepository("NNGenieInfosMatBundle:Etat");
        //selectionne les seuls materiels actifs
        $genres = $repositoryGenre->findBy(array("statut" => 1));
        $marques = $repositoryMarque->findBy(array("statut" => 1));
        $types = $repositoryType->findBy(array("statut" => 1));
        $localisations = $repositoryLocalisation->findBy(array("statut" => 1));
        $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));
        $etats = $repositoryEtat->findBy(array("statut" => 1));
        $response_text="";
        $response_number ="";
        $materiels = array();
        return $this->render('NNGenieInfosMatBundle:FrontEnd:view.demande.informations.html.twig', array('response_text' => $response_text, 'response_number' => $response_number, 'materiels' => $materiels, 'genres' => $genres, 'marques' => $marques, 'types' => $types, 'localisations' => $localisations, 'proprietaires' => $proprietaires, 'etats' => $etats));
    }

    
        /**
     * @Route("/results-search-materiels")
     * @Template()
     * @Method({"POST","GET"})
     * @param Request $request
     */
    public function getresultssearchAction(Request $request) {
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
            $idetats = $request->request->get("etats");
            $em = $this->getDoctrine()->getManager();

            $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
            $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
            $repositoryMarque = $em->getRepository("NNGenieInfosMatBundle:Marque");
            $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
            $repositoryLocalisation = $em->getRepository("NNGenieInfosMatBundle:Localisation");
            $repositoryProprietaire = $em->getRepository("NNGenieInfosMatBundle:Proprietaire");
            $repositoryEtat = $em->getRepository("NNGenieInfosMatBundle:Etat");
            //selectionne les seuls materiels actifs
            $materiels = $repositoryMateriel->filtreMaterielBy($idgrenres, $idmarques, $idtypes, $idproprietaires, $idlocalisations, $idetats);
            $genres = $repositoryGenre->findBy(array("statut" => 1));
            $marques = $repositoryMarque->findBy(array("statut" => 1));
            $types = $repositoryType->findBy(array("statut" => 1));
            $localisations = $repositoryLocalisation->findBy(array("statut" => 1));
            $proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));
            $etats = $repositoryEtat->findBy(array("statut" => 1));
            if($materiels){
                $response_number= count($materiels);
                $response_text = "OUI";
            }else{
                $response_text="NON";
                $response_number =0;
            }
            return $this->render('NNGenieInfosMatBundle:FrontEnd:view.demande.informations.html.twig', array('response_text' => $response_text, 'response_number' => $response_number, 'materiels' => $materiels, 'genres' => $genres, 'marques' => $marques, 'types' => $types, 'localisations' => $localisations, 'proprietaires' => $proprietaires, 'etats' => $etats));
        } else {
            return $this->redirect($this->generateUrl('nn_genie_infos_mat_ask_infos_user'));
        }
    }

}
