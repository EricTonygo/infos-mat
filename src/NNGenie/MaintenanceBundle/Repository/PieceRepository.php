<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of PieceRepository
 *
 * @author TONYE
 */
class PieceRepository extends EntityRepository{
    //put your code here
    public function deletePiece(\NNGenie\MaintenanceBundle\Entity\Piece $piece) {
        $em= $this->_em;
        $piece->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($piece);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function savePiece(\NNGenie\MaintenanceBundle\Entity\Piece $piece) {
        $em= $this->_em;
        $piece->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($piece);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updatePiece(\NNGenie\MaintenanceBundle\Entity\Piece $piece) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($piece);
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
    
    public function getPieceQueryBuilder() {
         return $this
          ->createQueryBuilder('p')
          ->where('p.statut = :statut')
          ->setParameter('statut', 1);
    }
}