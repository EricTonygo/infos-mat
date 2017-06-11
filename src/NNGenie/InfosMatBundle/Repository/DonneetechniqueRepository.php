<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of Donneetechnique
 *
 * @author TONYE
 */
class DonneetechniqueRepository extends EntityRepository implements IDonneetechniqueRepository {

    public function deleteDonneetechnique(\NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique) {
        $em = $this->_em;
        $donneetechnique->setStatut(0);
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($donneetechnique);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveDonneetechnique(\NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique) {
        $em = $this->_em;
        $donneetechnique->setStatut(1);
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($donneetechnique);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $donneetechnique;
    }

    public function getDonneetechniqueQueryBuilder() {
        return $this
                        ->createQueryBuilder('d')
                        ->where('d.statut = :statut')
                        ->setParameter('statut', 1);
    }

    public function updateDonneetechnique(\NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique) {
        $em = $this->_em;
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($donneetechnique);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $donneetechnique;
    }

//put your code here
}
