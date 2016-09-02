<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of LocationRepository
 *
 * @author TONYE
 */
class LocalisationRepository extends EntityRepository implements ILocalisationRepository{
    //put your code here
    public function deleteLocalisation(\NNGenie\InfosMatBundle\Entity\Localisation $localisation) {
        $em= $this->_em;
        $localisation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($localisation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveLocalisation(\NNGenie\InfosMatBundle\Entity\Localisation $localisation) {
        $em= $this->_em;
        $localisation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($localisation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateLocalisation(\NNGenie\InfosMatBundle\Entity\Localisation $localisation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($localisation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
