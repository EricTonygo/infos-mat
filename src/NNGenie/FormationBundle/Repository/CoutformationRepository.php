<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of CoutformationRepository
 *
 * @author TONYE
 */
class CoutformationRepository extends EntityRepository implements ICoutformationRepository{
    //put your code here
    
    public function deleteCoutformation(\NNGenie\FormationBundle\Entity\Coutformation $coutformation) {
        $em= $this->_em;
        $coutformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($coutformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveCoutformation(\NNGenie\FormationBundle\Entity\Coutformation $coutformation) {
        $em= $this->_em;
        $coutformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($coutformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateCoutformation(\NNGenie\FormationBundle\Entity\Coutformation $coutformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($coutformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getCoutformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
