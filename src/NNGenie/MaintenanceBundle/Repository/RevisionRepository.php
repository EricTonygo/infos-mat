<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of RevisionRepository
 *
 * @author TONYE
 */
class RevisionRepository extends EntityRepository{
    //put your code here
    public function deleteRevision(\NNGenie\MaintenanceBundle\Entity\Revision $anomalie) {
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


    public function saveRevision(\NNGenie\MaintenanceBundle\Entity\Revision $anomalie) {
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

    public function updateRevision(\NNGenie\MaintenanceBundle\Entity\Revision $anomalie) {
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
        $qb = $this->createQueryBuilder('r');
        $qb->where('r.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getRevisionQueryBuilder() {
         return $this
          ->createQueryBuilder('r')
          ->where('r.statut = :statut')
          ->setParameter('statut', 1);

    }
}