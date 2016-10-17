<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of TestRepository
 *
 * @author TONYE
 */
class TestRepository extends EntityRepository{
    //put your code here
    public function deleteTest(\NNGenie\MaintenanceBundle\Entity\Test $test) {
        $em= $this->_em;
        $test->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($test);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveTest(\NNGenie\MaintenanceBundle\Entity\Test $test) {
        $em= $this->_em;
        $test->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($test);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateTest(\NNGenie\MaintenanceBundle\Entity\Test $test) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($test);
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
    
    public function getTestQueryBuilder() {
         return $this
          ->createQueryBuilder('a')
          ->where('c.statut = :statut')
          ->setParameter('statut', 1);

    }
}