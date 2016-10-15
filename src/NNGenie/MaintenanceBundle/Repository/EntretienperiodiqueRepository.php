<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of EntretienperiodiqueRepository
 *
 * @author TONYE
 */
class EntretienperiodiqueRepository extends EntityRepository{
    //put your code here
    public function deleteEntretienperiodique(\NNGenie\MaintenanceBundle\Entity\Entretienperiodique $entretienperiodique) {
        $em= $this->_em;
        $entretienperiodique->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($entretienperiodique);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveEntretienperiodique(\NNGenie\MaintenanceBundle\Entity\Entretienperiodique $entretienperiodique) {
        $em= $this->_em;
        $entretienperiodique->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($entretienperiodique);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateEntretienperiodique(\NNGenie\MaintenanceBundle\Entity\Entretienperiodique $entretienperiodique) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($entretienperiodique);
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
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getEntretienperiodiqueQueryBuilder() {
         return $this
          ->createQueryBuilder('e')
          ->where('e.statut = :statut')
          ->setParameter('statut', 1);

    }
}