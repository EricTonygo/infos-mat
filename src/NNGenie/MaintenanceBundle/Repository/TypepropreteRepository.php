<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of TypepropreteRepository
 *
 * @author TONYE
 */
class TypepropreteRepository extends EntityRepository{
    //put your code here
    public function deleteTypeproprete(\NNGenie\MaintenanceBundle\Entity\Typeproprete $anomalie) {
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


    public function saveTypeproprete(\NNGenie\MaintenanceBundle\Entity\Typeproprete $anomalie) {
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

    public function updateTypeproprete(\NNGenie\MaintenanceBundle\Entity\Typeproprete $anomalie) {
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
    
    public function getTypepropreteQueryBuilder() {
         return $this
          ->createQueryBuilder('a')
          ->where('c.statut = :statut')
          ->setParameter('statut', 1);

    }
}