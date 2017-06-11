<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of AimeRepository
 *
 * @author TONYE
 */
class AimeRepository extends EntityRepository implements IAimeRepository{
    //put your code here
    public function deleteAime(\NNGenie\InfosMatBundle\Entity\Aime $aime) {
        $em= $this->_em;
        $aime->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($aime);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveAime(\NNGenie\InfosMatBundle\Entity\Aime $aime) {
        $em= $this->_em;
        $aime->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($aime);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $aime;
    }

    public function updateAime(\NNGenie\InfosMatBundle\Entity\Aime $aime) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($aime);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $aime;
    }
}
