<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of CentreformationRepository
 *
 * @author TONYE
 */
class CentreformationRepository extends EntityRepository implements ICentreformationRepository{
    //put your code here
    
    public function deleteCentreformation(\NNGenie\FormationBundle\Entity\Centreformation $centreformation) {
        $em= $this->_em;
        $centreformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($centreformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveCentreformation(\NNGenie\FormationBundle\Entity\Centreformation $centreformation) {
        $em= $this->_em;
        $centreformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($centreformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateCentreformation(\NNGenie\FormationBundle\Entity\Centreformation $centreformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($centreformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getCentreformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
