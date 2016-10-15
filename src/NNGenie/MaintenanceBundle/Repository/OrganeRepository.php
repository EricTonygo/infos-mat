<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of OrganeRepository
 *
 * @author TONYE
 */
class OrganeRepository extends EntityRepository{
    //put your code here
    public function deleteOrgane(\NNGenie\MaintenanceBundle\Entity\Organe $organe) {
        $em= $this->_em;
        $organe->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($organe);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveOrgane(\NNGenie\MaintenanceBundle\Entity\Organe $organe) {
        $em= $this->_em;
        $organe->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($organe);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateOrgane(\NNGenie\MaintenanceBundle\Entity\Organe $organe) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($organe);
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
    
    public function getOrganeQueryBuilder() {
         return $this
          ->createQueryBuilder('o')
          ->where('o.statut = :statut')
          ->setParameter('statut', 1);

    }
}