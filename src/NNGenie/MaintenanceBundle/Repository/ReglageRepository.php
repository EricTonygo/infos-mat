<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of ReglageRepository
 *
 * @author TONYE
 */
class ReglageRepository extends EntityRepository{
    //put your code here
    public function deleteReglage(\NNGenie\MaintenanceBundle\Entity\Reglage $reglage) {
        $em= $this->_em;
        $reglage->setStatut(0);
        $reglage->setTypereglage(null);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($reglage);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveReglage(\NNGenie\MaintenanceBundle\Entity\Reglage $reglage) {
        $em= $this->_em;
        $reglage->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($reglage);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateReglage(\NNGenie\MaintenanceBundle\Entity\Reglage $reglage) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($reglage);
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
        $qb = $this->createQueryBuilder('r');
        $qb->where('r.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getReglageQueryBuilder() {
         return $this
          ->createQueryBuilder('r')
          ->where('r.statut = :statut')
          ->setParameter('statut', 1);

    }
}