<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of FournisseurpieceRepository
 *
 * @author TONYE
 */
class FournisseurpieceRepository extends EntityRepository{
    //put your code here
    public function deleteFournisseurpiece(\NNGenie\MaintenanceBundle\Entity\Fournisseurpiece $fournisseurpiece) {
        $em= $this->_em;
        $fournisseurpiece->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($fournisseurpiece);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveFournisseurpiece(\NNGenie\MaintenanceBundle\Entity\Fournisseurpiece $fournisseurpiece) {
        $em= $this->_em;
        $fournisseurpiece->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($fournisseurpiece);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateFournisseurpiece(\NNGenie\MaintenanceBundle\Entity\Fournisseurpiece $fournisseurpiece) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($fournisseurpiece);
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
        $qb = $this->createQueryBuilder('f');
        $qb->where('f.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getFournisseurpieceQueryBuilder() {
         return $this
          ->createQueryBuilder('f')
          ->where('f.statut = :statut')
          ->setParameter('statut', 1);

    }
}