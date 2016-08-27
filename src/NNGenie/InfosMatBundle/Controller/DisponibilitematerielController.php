<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DisponibilitematerielController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $disponibilitemateriels = $em->getRepository('NNGenieInfosMatBundle:Disponibilitemateriel')->myFindAll();
        return $this->render('NNGenieInfosMatBundle:Disponibilitemateriel:index.html.twig', array(
            'disponibilitemateriels'=>$disponibilitemateriels
        ));
    }

    public function viewAction(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite)
    {
        $em = $this->getDoctrine()->getManager();
        $disponibilitemateriels = $em->getRepository('NNGenieInfosMatBundle:Disponibilitemateriel')->dispoMateriel($disponibilite);
        return $this->render('NNGenieInfosMatBundle:Disponibilitemateriel:index.html.twig', array(
            'disponibilitemateriels'=>$disponibilitemateriels
        ));
    }
    
    /**
        * @ParamConverter("materiel", options={"mapping": {"materiel_id": "id"}})
        * @ParamConverter("disponibilite", options={"mapping": {"disponibilite_id": "id"}})
    */
    public function newAction(Request $request,\NNGenie\InfosMatBundle\Entity\Materiel $materiel,\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite )
    {
        return $this->render('NNGenieInfosMatBundle:Disponibilitemateriel:new.html.twig', array(
            // ...
        ));
    }

    public function editAction()
    {
        return $this->render('NNGenieInfosMatBundle:Disponibilitemateriel:edit.html.twig', array(
            // ...
        ));
    }

    public function deleteAction()
    {
        return $this->render('NNGenieInfosMatBundle:Disponibilitemateriel:delete.html.twig', array(
            // ...
        ));
    }

}
