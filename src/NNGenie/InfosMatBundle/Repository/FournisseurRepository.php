<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of FournisseurRepository
 *
 * @author TONYE
 */
class FournisseurRepository extends EntityRepository implements IFournisseurRepository {

    //put your code here

    public function deleteFournisseur(\NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur) {
        $em = $this->_em;
        $fournisseur->setStatut(0);
        $materiel = new \NNGenie\InfosMatBundle\Entity\Materiel();
        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $em->getConnection()->beginTransaction();
        try {
            $materiels = $fournisseur->getMateriels();
            foreach ($materiel as $materiels) {
                $repositoryMateriel->deleteMateriel($materiel);
            }
            $em->persist($fournisseur);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveFournisseur(\NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur) {
        $em = $this->_em;
        $fournisseur->setStatut(1);
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($fournisseur);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $fournisseur;
    }

    public function updateFournisseur(\NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur) {
        $em = $this->_em;
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($fournisseur);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $fournisseur;
    }

    public function getFournisseurQueryBuilder() {
        return $this
                        ->createQueryBuilder('f')
                        ->where('f.statut = :statut')
                        ->setParameter('statut', 1);
    }

}
