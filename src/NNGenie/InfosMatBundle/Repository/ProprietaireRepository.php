<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ProprietaireRepository
 *
 * @author TONYE
 */
class ProprietaireRepository extends EntityRepository implements IProprietaireRepository{
    //put your code here
    
    public function deleteProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire) {
        $em= $this->_em;
        $proprietaire->setStatut(0);
		$materiel = new \NNGenie\InfosMatBundle\Entity\Materiel();
        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
		$em->getConnection()->beginTransaction();
        try{
			$materiels = $proprietaire->getMateriels();
            foreach ($materiel as $materiels) {
                $repositoryMateriel->deleteMateriel($materiel);
            }
            $em->persist($proprietaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire) {
        $em= $this->_em;
        $proprietaire->setStatut(1);
		$em->getConnection()->beginTransaction();
        try{
            $em->persist($proprietaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire) {
        $em= $this->_em;
		$em->getConnection()->beginTransaction();
        try{
            $em->persist($proprietaire);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
