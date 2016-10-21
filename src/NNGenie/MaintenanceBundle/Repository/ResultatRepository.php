<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of ResultatRepository
 *
 * @author TONYE
 */
class ResultatRepository extends EntityRepository{
    //put your code here
    public function deleteResultat(\NNGenie\MaintenanceBundle\Entity\Resultat $resultat) {
        $em= $this->_em;
        $resultat->setStatut(0);
        $resultat->setTest(null);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($resultat);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveResultat(\NNGenie\MaintenanceBundle\Entity\Resultat $resultat) {
        $em= $this->_em;
        $resultat->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($resultat);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateResultat(\NNGenie\MaintenanceBundle\Entity\Resultat $resultat) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($resultat);
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
    
    public function getResultatQueryBuilder() {
         return $this
          ->createQueryBuilder('r')
          ->where('r.statut = :statut')
          ->setParameter('statut', 1);

    }
}