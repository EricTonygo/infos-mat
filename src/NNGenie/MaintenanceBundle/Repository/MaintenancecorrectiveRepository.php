<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of MaintenancecorrectiveRepository
 *
 * @author TONYE
 */
class MaintenancecorrectiveRepository extends EntityRepository{
    //put your code here
    public function deleteMaintenancecorrective(\NNGenie\MaintenanceBundle\Entity\Maintenancecorrective $maintenancecorrective) {
        $em= $this->_em;
        $maintenancecorrective->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenancecorrective);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveMaintenancecorrective(\NNGenie\MaintenanceBundle\Entity\Maintenancecorrective $maintenancecorrective) {
        $em= $this->_em;
        $maintenancecorrective->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenancecorrective);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateMaintenancecorrective(\NNGenie\MaintenanceBundle\Entity\Maintenancecorrective $maintenancecorrective) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($maintenancecorrective);
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
    
    public function getMaintenancecorrectiveQueryBuilder() {
         return $this
          ->createQueryBuilder('m')
          ->where('m.statut = :statut')
          ->setParameter('statut', 1);

    }
}