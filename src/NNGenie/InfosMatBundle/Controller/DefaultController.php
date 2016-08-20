<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
		//$repositoryMateriel = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Materiel");
		//$materiels = $repositoryMateriel->findBy(array("statut" => 1));
		
		//return $this->render('NNGenieInfosMatBundle::index.html.twig', array("materiels"=> $materiels));
		return $this->render('NNGenieInfosMatBundle:Administration:index.html.twig');
        
    }
}
