<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of ControlematinalRepository
 *
 * @author TONYE
 */
class ControlematinalRepository extends EntityRepository{
    //put your code here
    public function deleteControlematinal(\NNGenie\MaintenanceBundle\Entity\Controlematinal $controlematinal) {
        $em= $this->_em;
        $controlematinal->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($controlematinal);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveControlematinal(\NNGenie\MaintenanceBundle\Entity\Controlematinal $controlematinal) {
        $em= $this->_em;
        $controlematinal->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($controlematinal);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateControlematinal(\NNGenie\MaintenanceBundle\Entity\Controlematinal $controlematinal) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($controlematinal);
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
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getControlematinalQueryBuilder() {
         return $this
          ->createQueryBuilder('c')
          ->where('c.statut = :statut')
          ->setParameter('statut', 1);

    }
}