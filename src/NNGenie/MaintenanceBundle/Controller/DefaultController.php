<?php

namespace NNGenie\MaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        $repositoryType = $this->getDoctrine()->getManager()->getRepository("NNGenieInfosMatBundle:Type");
        $types = $repositoryType->findBy(array('statut' => 1));
        $repositoryPanne = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Panne");
        $pannes = $repositoryPanne->findBy(array("statut" => 1));
        $repositoryAnomalie = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Anomalie");
        $anomalies = $repositoryAnomalie->findBy(array("statut" => 1));
        $repositoryControleMatinal = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Controlematinal");
        $controlesMatinaux = $repositoryControleMatinal->findBy(array("statut" => 1));
        $repositoryRevision = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Revision");
        $revisions = $repositoryRevision->findBy(array("statut" => 1));
        $repositoryProcede = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Procede");
        $procedes = $repositoryProcede->findBy(array("statut" => 1));
        $repositoryReglage = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Reglage");
        $reglages = $repositoryReglage->findBy(array("statut" => 1));
        $repositoryProprete = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Proprete");
        $propretes = $repositoryProprete->findBy(array("statut" => 1));
        $repositoryEntretienPeriodique = $this->getDoctrine()->getManager()->getRepository("NNGenieMaintenanceBundle:Entretienperiodique");
        $entretiensperiodiques = $repositoryEntretienPeriodique->findBy(array("statut" => 1));
        return $this->render('NNGenieMaintenanceBundle:Accueil:accueil.html.twig', array("types" => $types, "nbpannes" => count($pannes), "nbanomalies" => count($anomalies), "nbcontrolesMatinaux" => count($controlesMatinaux),
                "nbrevisions" => count($revisions), "nbprocedes" => count($procedes), "nbreglages" => count($reglages), "nbpropretes" => count($propretes), "nbentretiensperiodiques" => count($entretiensperiodiques)));
    }
}
