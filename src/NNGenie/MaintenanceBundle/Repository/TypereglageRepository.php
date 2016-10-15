<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of TypereglageRepository
 *
 * @author TONYE
 */
class TypereglageRepository extends EntityRepository{
    //put your code here
    public function deleteTypereglage(\NNGenie\MaintenanceBundle\Entity\Typereglage $typereglage) {
        $em= $this->_em;
        $typereglage->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($typereglage);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveTypereglage(\NNGenie\MaintenanceBundle\Entity\Typereglage $typereglage) {
        $em= $this->_em;
        $typereglage->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($typereglage);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateTypereglage(\NNGenie\MaintenanceBundle\Entity\Typereglage $typereglage) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($typereglage);
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
    
    public function getTypereglageQueryBuilder() {
         return $this
          ->createQueryBuilder('a')
          ->where('c.statut = :statut')
          ->setParameter('statut', 1);

    }
}