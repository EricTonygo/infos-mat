<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of MaintenancepreventiveRepository
 *
 * @author TONYE
 */
class MaintenancepreventiveRepository extends EntityRepository{
    //put your code here
    public function deleteMaintenancepreventive(\NNGenie\MaintenanceBundle\Entity\Maintenancepreventive $maintenancepreventive) {
        $em= $this->_em;
        $maintenancepreventive->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenancepreventive);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveMaintenancepreventive(\NNGenie\MaintenanceBundle\Entity\Maintenancepreventive $maintenancepreventive) {
        $em= $this->_em;
        $maintenancepreventive->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenancepreventive);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateMaintenancepreventive(\NNGenie\MaintenanceBundle\Entity\Maintenancepreventive $maintenancepreventive) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenancepreventive);
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
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getMaintenancepreventiveQueryBuilder() {
         return $this
          ->createQueryBuilder('m')
          ->where('m.statut = :statut')
          ->setParameter('statut', 1);

    }
}