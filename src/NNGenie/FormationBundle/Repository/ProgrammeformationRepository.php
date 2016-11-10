<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ProgrammeformationRepository
 *
 * @author TONYE
 */
class ProgrammeformationRepository extends EntityRepository implements IProgrammeformationRepository{
    //put your code here
    
    public function deleteProgrammeformation(\NNGenie\FormationBundle\Entity\Programmeformation $programmeformation) {
        $em= $this->_em;
        $programmeformation->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($programmeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveProgrammeformation(\NNGenie\FormationBundle\Entity\Programmeformation $programmeformation) {
        $em= $this->_em;
        $programmeformation->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($programmeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateProgrammeformation(\NNGenie\FormationBundle\Entity\Programmeformation $programmeformation) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($programmeformation);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }
    
    public function getProgrammeformationQueryBuilder() {
        return $this
         ->createQueryBuilder('e')
         ->where('e.statut = :statut')
         ->setParameter('statut', 1);

    }
}
