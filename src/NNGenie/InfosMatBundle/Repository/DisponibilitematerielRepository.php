<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of DisponibilitematerielRepository
 *
 * @author TONYE
 */
class DisponibilitematerielRepository extends EntityRepository implements IDisponibilitematerielRepository{
    public function deleteDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel) {
        $em= $this->_em;
        $disponibilitemateriel->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($disponibilitemateriel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel) {
        $em= $this->_em;
        $disponibilitemateriel->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($disponibilitemateriel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($disponibilitemateriel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
