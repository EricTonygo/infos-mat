<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of ProduitRepository
 *
 * @author TONYE
 */
class ProduitRepository extends EntityRepository{
    //put your code here
    public function deleteProduit(\NNGenie\MaintenanceBundle\Entity\Produit $produit) {
        $em= $this->_em;
        $produit->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($produit);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveProduit(\NNGenie\MaintenanceBundle\Entity\Produit $produit) {
        $em= $this->_em;
        $produit->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($produit);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProduit(\NNGenie\MaintenanceBundle\Entity\Produit $produit) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($produit);
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
    
    public function getProduitQueryBuilder() {
         return $this
          ->createQueryBuilder('p')
          ->where('p.statut = :statut')
          ->setParameter('statut', 1);

    }
}