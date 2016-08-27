<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of MarqueRepository
 *
 * @author TONYE
 */
class MarqueRepository extends EntityRepository implements IMarqueRepository{
    //put your code here
    
    public function deleteMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque) {
        $em= $this->_em;
        $marque->setStatut(0);
        $type= new \NNGenie\InfosMatBundle\Entity\Aime();
        $repositoryType = $em->getRepository("NNGenieInfosMatBundle:Type");
		$em->getConnection()->beginTransaction();
        try{
            $types = $marque->getTypes();
            foreach ($type as $types) {
                $repositoryType->deleteType($type);
            }
            $em->persist($marque);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque) {
        $em= $this->_em;
        $marque->setStatut(1);
		$em->getConnection()->beginTransaction();
        try{
            $em->persist($marque);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque) {
        $em= $this->_em;
		$em->getConnection()->beginTransaction();
        try{
            $em->persist($marque);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
