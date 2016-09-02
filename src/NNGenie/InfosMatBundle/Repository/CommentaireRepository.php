<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of CommentaireRepository
 *
 * @author TONYE
 */
class CommentaireRepository extends EntityRepository implements ICommentaireRespository{
    public function deleteCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire) {
        $em= $this->_em;
        $commentaire->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($commentaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire) {
        $em= $this->_em;
        $commentaire->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($commentaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($commentaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    public function FindAllCommentUserMateriel(\NNGenie\UserBundle\Entity\User $user=null,\NNGenie\InfosMatBundle\Entity\Materiel $materiel=null) {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.statut = :statut')
           ->setParameter('statut', 1);
        if($user!=null) {
            $qb->andWhere('c.user = :user')
               ->setParameter('user', $user);
        }
        if($materiel!=null) {
            $qb->andWhere('c.materiel = :materiel')
               ->setParameter('materiel', $materiel);
        }
        return $qb->getQuery()->getResult();
    }

//put your code here
}
