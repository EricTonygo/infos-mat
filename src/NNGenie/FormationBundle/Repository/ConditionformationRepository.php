<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ConditionformationRepository
 *
 * @author TONYE
 */
class ConditionformationRepository extends EntityRepository implements IConditionformationRepository{
    //put your code here
    
    public function deleteConditionformation(\NNGenie\FormationBundle\Entity\Conditionformation $conditionformation) {
        $em= $this->_em;
        $conditionformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($conditionformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveConditionformation(\NNGenie\FormationBundle\Entity\Conditionformation $conditionformation) {
        $em= $this->_em;
        $conditionformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($conditionformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateConditionformation(\NNGenie\FormationBundle\Entity\Conditionformation $conditionformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($conditionformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getConditionformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
