<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ContenuformationRepository
 *
 * @author TONYE
 */
class ContenuformationRepository extends EntityRepository implements IContenuformationRepository{
    //put your code here
    
    public function deleteContenuformation(\NNGenie\FormationBundle\Entity\Contenuformation $contenuformation) {
        $em= $this->_em;
        $contenuformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($contenuformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveContenuformation(\NNGenie\FormationBundle\Entity\Contenuformation $contenuformation) {
        $em= $this->_em;
        $contenuformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($contenuformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateContenuformation(\NNGenie\FormationBundle\Entity\Contenuformation $contenuformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($contenuformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getContenuformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
