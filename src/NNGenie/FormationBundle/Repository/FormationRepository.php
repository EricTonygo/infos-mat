<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of FormationRepository
 *
 * @author TONYE
 */
class FormationRepository extends EntityRepository implements IFormationRepository{
    //put your code here
    
    public function deleteFormation(\NNGenie\FormationBundle\Entity\Formation $formation) {
        $em= $this->_em;
        $formation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($formation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveFormation(\NNGenie\FormationBundle\Entity\Formation $formation) {
        $em= $this->_em;
        $formation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($formation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateFormation(\NNGenie\FormationBundle\Entity\Formation $formation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($formation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getFormationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
