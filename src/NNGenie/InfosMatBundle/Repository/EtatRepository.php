<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of EtatRepository
 *
 * @author TONYE
 */
class EtatRepository extends EntityRepository implements IEtatRepository{
    //put your code here
    public function deleteEtat(\NNGenie\InfosMatBundle\Entity\Etat $etat) {
        $em= $this->_em;
        $etat->setStatut(0);
		$materiel = new \NNGenie\InfosMatBundle\Entity\Materiel();
        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $em->getConnection()->beginTransaction();
        try{
			$materiels = $etat->getMateriels();
            foreach ($materiel as $materiels) {
                $repositoryMateriel->deleteMateriel($materiel);
            }
            $em->persist($etat);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveEtat(\NNGenie\InfosMatBundle\Entity\Etat $etat) {
        $em= $this->_em;
        $etat->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($etat);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $etat;
    }

    public function updateEtat(\NNGenie\InfosMatBundle\Entity\Etat $etat) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($etat);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $etat;
    }
    
    public function myFindAll() 
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }

    public function getEtatQueryBuilder() {
         return $this
          ->createQueryBuilder('e')
          ->where('e.statut = :statut')
          ->setParameter('statut', 1);

    }
}
