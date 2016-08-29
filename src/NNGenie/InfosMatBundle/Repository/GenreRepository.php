<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of GenreRepository
 *
 * @author TONYE
 */
class GenreRepository extends EntityRepository implements IGenreRepository{
    //put your code here
    
    public function deleteGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre) {
        $em= $this->_em;
        $genre->setStatut(0);
		$materiel = new \NNGenie\InfosMatBundle\Entity\Materiel();
        $repositoryMateriel = $em->getRepository("NNGenieInfosMatBundle:Materiel");
        $em->getConnection()->beginTransaction();
        try{
			$materiels = $genre->getMateriels();
            foreach ($materiel as $materiels) {
                $repositoryMateriel->deleteMateriel($materiel);
            }
            $em->persist($genre);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre) {
        $em= $this->_em;
        $genre->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($genre);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($genre);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
