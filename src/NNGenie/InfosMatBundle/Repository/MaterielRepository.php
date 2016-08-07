<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of MaterielRepository
 *
 * @author TONYE
 */
class MaterielRepository extends EntityRepository implements IMaterielRepository{
    //put your code here
    public function deleteMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel) {
        $em= $this->_em;
        $materiel->setStatut(0);
        $aime= new \NNGenie\InfosMatBundle\Entity\Aime();
        $repositoryAime = $em->getRepository("NNGenieInfosMatBundle:Aime");
        $commentaire= new \NNGenie\InfosMatBundle\Entity\Commentaire();
        $repositoryCommentaire= $em->getRepository("NNGenieInfosMatBundle:Commentaire");
        $em->getConnection()->beginTransaction();
        try{
            $aimes = $materiel->getAimes();
            $commentaires = $materiel->getCommentaires();
            foreach ($aime as $aimes) {
                $repositoryAime->deleteAime($aime);
            }
            foreach ($commentaire as $commentaires) {
                $repositoryCommentaire->deleteCommentaire($commentaire);
            }
            $em->persist($materiel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel) {
        $em= $this->_em;
        $materiel->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($materiel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($materiel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
