<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ProprietaireRepository
 *
 * @author TONYE
 */
class ProprietaireRepository extends EntityRepository implements IProprietaireRepository{
    //put your code here
    
    public function deleteProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire) {
        $em= $this->_em;
        $proprietaire->setStatut(0);
        try{
            $em->persist($proprietaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire) {
        $em= $this->_em;
        $proprietaire->setStatut(1);
        try{
            $em->persist($proprietaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire) {
        $em= $this->_em;
        try{
            $em->persist($proprietaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
