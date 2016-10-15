<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of AnomalieRepository
 *
 * @author TONYE
 */
class AnomalieRepository extends EntityRepository{
    //put your code here
    public function deleteAnomalie(\NNGenie\MaintenanceBundle\Entity\Anomalie $anomalie) {
        $em= $this->_em;
        $anomalie->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($anomalie);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveAnomalie(\NNGenie\MaintenanceBundle\Entity\Anomalie $anomalie) {
        $em= $this->_em;
        $anomalie->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($anomalie);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateAnomalie(\NNGenie\MaintenanceBundle\Entity\Anomalie $anomalie) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($anomalie);
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
        $qb = $this->createQueryBuilder('a');
        $qb->where('c.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getAnomalieQueryBuilder() {
         return $this
          ->createQueryBuilder('a')
          ->where('c.statut = :statut')
          ->setParameter('statut', 1);

    }
}