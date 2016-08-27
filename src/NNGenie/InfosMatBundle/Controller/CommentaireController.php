<?php

namespace NNGenie\InfosMatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    public function indexAction(\NNGenie\InfosMatBundle\Entity\Materiel $materiel)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaires=$em->getRepository('NNGenieInfosMatBundle:Commentaire')->FindAllCommentUserMateriel($materiel);
        return $this->render('NNGenieInfosMatBundle:Commentaire:index.html.twig', array(
            'commentaires' => $commentaires
        ));
    }
    /**
        * @ParamConverter("materiel", options={"mapping": {"materiel_id": "id"}})
        * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
    */
    public function newAction(Request $request,\NNGenie\InfosMatBundle\Entity\Materiel $materiel,\NNGenie\UserBundle\Entity\User $user)
    {
        $commentaire = new \NNGenie\InfosMatBundle\Entity\Commentaire();
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\CommentaireType', $commentaire, 
                                    array('action'=>$this->generateUrl('nn_genie_infos_mat_commentaire_new',array('materiel_id'=>$materiel->getId(),'user_id'=>$user->getId()))));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $commentaire->setUser($user);
            $commentaire->setMateriel($materiel);
            $em->getRepository('NNGenieInfosMatBundle:Commentaire')->saveCommentaire($commentaire);
            return $this->redirectToRoute('nn_genie_infos_mat_commentaire_view', array('id' => $commentaire->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:Commentaire:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
        * @ParamConverter("materiel", options={"mapping": {"materiel_id": "id"}})
        * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
    */
    public function viewAction(\NNGenie\InfosMatBundle\Entity\Materiel $materiel=null,\NNGenie\UserBundle\Entity\User $user=null) {
        $em = $this->getDoctrine()->getManager();
        $commentaires=$em->getRepository('NNGenieInfosMatBundle:Commentaire')->FindAllCommentUserMateriel($user,$materiel);
        return $this->render('NNGenieInfosMatBundle:Commentaire:index.html.twig', array(
            'commentaires'=>$commentaires
        ));
    }
    
    /**
        * @ParamConverter("commentaire", options={"mapping": {"commentaire_id": "id"}})
        * @ParamConverter("materiel", options={"mapping": {"materiel_id": "id"}})
    */
    public function deleteAction(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire,\NNGenie\InfosMatBundle\Entity\Materiel $materiel)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('NNGenieInfosMatBundle:Commentaire')->deleteCommentaire($commentaire);
        return $this->redirectToRoute('nn_genie_infos_mat_commentaire_index',array('id'=>$materiel->getId()));
    }
    
    /**
        * @ParamConverter("commentaire", options={"mapping": {"commentaire_id": "id"}})
        * @ParamConverter("materiel", options={"mapping": {"materiel_id": "id"}})
    */
    public function editAction(Request $request,\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire,\NNGenie\InfosMatBundle\Entity\Materiel $materiel) {
        $form = $this->createForm('NNGenie\InfosMatBundle\Form\CommentaireType', $commentaire,
                                                    array('action'=>$this->generateUrl('nn_genie_infos_mat_commentaire_edit',array('commentaire_id'=>$commentaire->getId(),'materiel_id'=>$materiel->getId()))));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('NNGenieInfosMatBundle:Commentaire')->updateCommentaire($commentaire);
            return $this->redirectToRoute('nn_genie_infos_mat_commentaire_index', array('id' => $materiel->getId()));
        }
        return $this->render('NNGenieInfosMatBundle:Commentaire:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

}