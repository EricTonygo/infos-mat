<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of AdresseRepository
 *
 * @author TONYE
 */
class AdresseRepository extends EntityRepository implements IAdresseRepository{
    //put your code here
    public function deleteAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse) {
        $em= $this->_em;
        $adresse->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($adresse);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse) {
        $em= $this->_em;
        $adresse->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($adresse);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($adresse);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
}
