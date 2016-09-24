<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of Donneetechniquetype
 *
 * @author TONYE
 */
class DonneetechniquetypeRepository extends EntityRepository implements IDonneetechniquetypeRepository{
    public function deleteDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype) {
        $em= $this->_em;
        $donneetechniquetype->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($donneetechniquetype);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype) {
        $em= $this->_em;
        $donneetechniquetype->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($donneetechniquetype);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($donneetechniquetype);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
//put your code here
}
