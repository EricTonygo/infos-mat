<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of MaintenanceRepository
 *
 * @author TONYE
 */
class MaintenanceRepository extends EntityRepository{
    //put your code here
    public function deleteMaintenance(\NNGenie\MaintenanceBundle\Entity\Maintenance $maintenance) {
        $em= $this->_em;
        $maintenance->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenance);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveMaintenance(\NNGenie\MaintenanceBundle\Entity\Maintenance $maintenance) {
        $em= $this->_em;
        $maintenance->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenance);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateMaintenance(\NNGenie\MaintenanceBundle\Entity\Maintenance $maintenance) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenance);
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
    
    public function getMaintenanceQueryBuilder() {
         return $this
          ->createQueryBuilder('m')
          ->where('m.statut = :statut')
          ->setParameter('statut', 1);

    }
}