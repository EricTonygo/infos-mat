<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of TypeRepository
 *
 * @author TONYE
 */
class TypeRepository extends EntityRepository implements ITypeRepository{
    //put your code here
    public function deleteType(\NNGenie\InfosMatBundle\Entity\Type $type) {
        $em= $this->_em;
        $type->setStatut(0);
        try{
            $em->persist($type);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveType(\NNGenie\InfosMatBundle\Entity\Type $type) {
        $em= $this->_em;
        $type->setStatut(0);
        try{
            $em->persist($type);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateType(\NNGenie\InfosMatBundle\Entity\Type $type) {
        $em= $this->_em;
        try{
            $em->persist($type);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
