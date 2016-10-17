<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of PanneRepository
 *
 * @author TONYE
 */
class PanneRepository extends EntityRepository{
    //put your code here
    public function deletePanne(\NNGenie\MaintenanceBundle\Entity\Panne $panne) {
        $em= $this->_em;
        $panne->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($panne);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function savePanne(\NNGenie\MaintenanceBundle\Entity\Panne $panne) {
        $em= $this->_em;
        $panne->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($panne);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updatePanne(\NNGenie\MaintenanceBundle\Entity\Panne $panne) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($panne);
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
    
    public function getPanneQueryBuilder() {
         return $this
          ->createQueryBuilder('p')
          ->where('p.statut = :statut')
          ->setParameter('statut', 1);

    }
}