<?php

namespace NNGenie\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $repositoryFormation = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Formation");
        $userManager = $this->container->get('fos_user.user_manager');
        $repositoryCentre = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Centreformation");
        $repositoryProgramme = $this->getDoctrine()->getManager()->getRepository("NNGenieFormationBundle:Programmeformation");
        $formations = $repositoryFormation->findBy(array("statut" => 1));
        $users = $userManager->findUsers();
        $centre = $repositoryCentre->findBy(array("statut" => 1));
        $programme = $repositoryProgramme->findBy(array("statut" => 1));

        //return $this->render('NNGenieInfosMatBundle::index.html.twig', array("materiels"=> $materiels));
        return $this->render('NNGenieFormationBundle:Accueil:index.html.twig', array('nombreUsers' => count($users), 'nombreFormations' => count($formations), 'nombreCentres' => count($centre), 'nombreProgrammes' => count($programme)));
    }
}
