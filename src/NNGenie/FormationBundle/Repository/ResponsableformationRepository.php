<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ResponsableformationRepository
 *
 * @author TONYE
 */
class ResponsableformationRepository extends EntityRepository implements IResponsableformationRepository{
    //put your code here
    
    public function deleteResponsableformation(\NNGenie\FormationBundle\Entity\Responsableformation $responsableformation) {
        $em= $this->_em;
        $responsableformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($responsableformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveResponsableformation(\NNGenie\FormationBundle\Entity\Responsableformation $responsableformation) {
        $em= $this->_em;
        $responsableformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($responsableformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateResponsableformation(\NNGenie\FormationBundle\Entity\Responsableformation $responsableformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($responsableformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getResponsableformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
