<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of OperationRepository
 *
 * @author TONYE
 */
class OperationRepository extends EntityRepository{
    //put your code here
    public function deleteOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $em= $this->_em;
        $operation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($operation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $em= $this->_em;
        $operation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($operation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($operation);
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
        $qb = $this->createQueryBuilder('o');
        $qb->where('o.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getOperationQueryBuilder() {
         return $this
          ->createQueryBuilder('o')
          ->where('o.statut = :statut')
          ->setParameter('statut', 1);

    }
}