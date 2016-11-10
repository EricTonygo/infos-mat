<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of FormeformationRepository
 *
 * @author TONYE
 */
class FormeformationRepository extends EntityRepository implements IFormeformationRepository{
    //put your code here
    
    public function deleteFormeformation(\NNGenie\FormationBundle\Entity\Formeformation $formeformation) {
        $em= $this->_em;
        $formeformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($formeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveFormeformation(\NNGenie\FormationBundle\Entity\Formeformation $formeformation) {
        $em= $this->_em;
        $formeformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($formeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateFormeformation(\NNGenie\FormationBundle\Entity\Formeformation $formeformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($formeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getFormeformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
