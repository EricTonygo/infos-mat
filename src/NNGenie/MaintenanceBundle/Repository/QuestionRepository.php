<?php

namespace NNGenie\MaintenanceBundle\Repository;


use Doctrine\ORM\EntityRepository;
/**
 * Description of QuestionRepository
 *
 * @author TONYE
 */
class QuestionRepository extends EntityRepository{
    //put your code here
    public function deleteQuestion(\NNGenie\MaintenanceBundle\Entity\Question $question) {
        $em= $this->_em;
        $question->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($question);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }


    public function saveQuestion(\NNGenie\MaintenanceBundle\Entity\Question $question) {
        $em= $this->_em;
        $question->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($question);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateQuestion(\NNGenie\MaintenanceBundle\Entity\Question $question) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($question);
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
        $qb = $this->createQueryBuilder('q');
        $qb->where('q.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getQuestionQueryBuilder() {
         return $this
          ->createQueryBuilder('q')
          ->where('q.statut = :statut')
          ->setParameter('statut', 1);

    }
}