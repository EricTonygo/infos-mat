<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of ProcedeRepository
 *
 * @author TONYE
 */
class ProcedeRepository extends EntityRepository{
    //put your code here
    public function deleteProcede(\NNGenie\MaintenanceBundle\Entity\Procede $procede) {
        $em= $this->_em;
        $procede->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($procede);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveProcede(\NNGenie\MaintenanceBundle\Entity\Procede $procede) {
        $em= $this->_em;
        $procede->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($procede);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProcede(\NNGenie\MaintenanceBundle\Entity\Procede $procede) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($procede);
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
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getProcedeQueryBuilder() {
         return $this
          ->createQueryBuilder('p')
          ->where('p.statut = :statut')
          ->setParameter('statut', 1);

    }
}