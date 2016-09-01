<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
		if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirect($this->generateUrl('fos_user_security_login'));
          }
		$repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");
		$userManager = $this->container->get('fos_user.user_manager');
		$repositoryFournisseur = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Fournisseur");
		$repositoryProprietaire = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Proprietaire");
		$materiels = $repositoryMateriel->findBy(array("statut" => 1));
		$users = $userManager->findUsers();
		$fournisseurs = $repositoryFournisseur->findBy(array("statut" => 1));
		$proprietaires = $repositoryProprietaire->findBy(array("statut" => 1));
		
		//return $this->render('NNGenieInfosMatBundle::index.html.twig', array("materiels"=> $materiels));
		return $this->render('NNGenieInfosMatBundle:Administration:index.html.twig', array('nombreUsers' => count($users), 'nombreMateriels' => count($materiels), 'nombreFounisseurs' => count($fournisseurs), 'nombreProprietaires' => count($proprietaires)));
        
    }
}
