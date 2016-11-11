<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of TypeformationRepository
 *
 * @author TONYE
 */
class TypeformationRepository extends EntityRepository implements ITypeformationRepository{
    //put your code here
    
    public function deleteTypeformation(\NNGenie\FormationBundle\Entity\Typeformation $typeformation) {
        $em= $this->_em;
        $typeformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($typeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveTypeformation(\NNGenie\FormationBundle\Entity\Typeformation $typeformation) {
        $em= $this->_em;
        $typeformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($typeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateTypeformation(\NNGenie\FormationBundle\Entity\Typeformation $typeformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($typeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getTypeformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
