<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of TitulaireformationRepository
 *
 * @author TONYE
 */
class TitulaireformationRepository extends EntityRepository implements ITitulaireformationRepository{
    //put your code here
    
    public function deleteTitulaireformation(\NNGenie\FormationBundle\Entity\Titulaireformation $titulaireformation) {
        $em= $this->_em;
        $titulaireformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($titulaireformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveTitulaireformation(\NNGenie\FormationBundle\Entity\Titulaireformation $titulaireformation) {
        $em= $this->_em;
        $titulaireformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($titulaireformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateTitulaireformation(\NNGenie\FormationBundle\Entity\Titulaireformation $titulaireformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($titulaireformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getTitulaireformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
