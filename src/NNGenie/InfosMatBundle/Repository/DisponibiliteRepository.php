<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of Disponibilite
 *
 * @author TONYE
 */
class DisponibiliteRepository extends EntityRepository implements IDisponibiliteRepository{
    public function deleteDisponibilite(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite) {
        $em= $this->_em;
        $disponibilite->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($disponibilite);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveDisponibilite(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite) {
        $em= $this->_em;
        $disponibilite->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($disponibilite);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateDisponibilite(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($disponibilite);
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
        $qb = $this->createQueryBuilder('d');
        $qb->where('d.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }

//put your code here
}
