<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of PropreteRepository
 *
 * @author TONYE
 */
class PropreteRepository extends EntityRepository{
    //put your code here
    public function deleteProprete(\NNGenie\MaintenanceBundle\Entity\Proprete $proprete) {
        $em= $this->_em;
        $proprete->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($proprete);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveProprete(\NNGenie\MaintenanceBundle\Entity\Proprete $proprete) {
        $em= $this->_em;
        $proprete->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($proprete);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProprete(\NNGenie\MaintenanceBundle\Entity\Proprete $proprete) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($proprete);
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
        $qb->where('c.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getPropreteQueryBuilder() {
         return $this
          ->createQueryBuilder('p')
          ->where('p.statut = :statut')
          ->setParameter('statut', 1);

    }
}