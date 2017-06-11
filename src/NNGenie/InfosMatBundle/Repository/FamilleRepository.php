<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of FamilleRepository
 *
 * @author TONYE
 */
class FamilleRepository extends EntityRepository implements IFamilleRepository{
    //put your code here
    
    public function deleteFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille) {
        $em= $this->_em;
        $famille->setStatut(0);
        $genre = new \NNGenie\InfosMatBundle\Entity\Genre();
        $repositoryGenre = $em->getRepository("NNGenieInfosMatBundle:Genre");
        $em->getConnection()->beginTransaction();
        try{
            $genres = $famille->getGenres();
            foreach ($genre as $genres) {
                $repositoryGenre->deleteGenre($genre);
            }
            $em->persist($famille);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille) {
        $em= $this->_em;
        $famille->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($famille);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $famille;
    }

    public function updateFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($famille);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
        return $famille;
    }
    public function myFindAll() 
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where('f.statut = :statut')
           ->setParameter('statut', 1);
        return $qb->getQuery()->getResult();
    }
    
    public function getFamilleQueryBuilder() {
         return $this
          ->createQueryBuilder('f')
          ->where('f.statut = :statut')
          ->setParameter('statut', 1);

    }
}
