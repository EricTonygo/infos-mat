<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of ClassematerielRepository
 *
 * @author TONYE
 */
class ClassematerielRepository extends EntityRepository implements IClassematerielRepository{
    //put your code here
    public function deleteClassemateriel(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel) {
        $em= $this->_em;
        $classemateriel->setStatut(0);
        $famille = new \NNGenie\InfosMatBundle\Entity\Famille();
        $repositoryFamille = $em->getRepository("NNGenieInfosMatBundle:Famille");
        $em->getConnection()->beginTransaction();
        try{
            $familles = $classemateriel->getFamilles();
            foreach ($famille as $familles) {
                $repositoryFamille->deleteFamille($famille);
            }
            $em->persist($classemateriel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveClassemateriel(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel) {
        $em= $this->_em;
        $classemateriel->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($classemateriel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateClassemateriel(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($classemateriel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    public function myFindAll() 
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getCMaterielQueryBuilder() {
         return $this
          ->createQueryBuilder('c')
          ->where('c.statut = :statut')
          ->setParameter('statut', 1);

    }
}