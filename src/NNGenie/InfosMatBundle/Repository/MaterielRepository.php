<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of MaterielRepository
 *
 * @author TONYE
 */
class MaterielRepository extends EntityRepository implements IMaterielRepository {

    //put your code here
    public function deleteMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel) {
        $em = $this->_em;
        $materiel->setStatut(0);
        $aime = new \NNGenie\InfosMatBundle\Entity\Aime();
        $repositoryAime = $em->getRepository("NNGenieInfosMatBundle:Aime");
        $commentaire = new \NNGenie\InfosMatBundle\Entity\Commentaire();
        $repositoryCommentaire = $em->getRepository("NNGenieInfosMatBundle:Commentaire");
        $em->getConnection()->beginTransaction();
        try {
            $aimes = $materiel->getAimes();
            $commentaires = $materiel->getCommentaires();
            foreach ($aime as $aimes) {
                $repositoryAime->deleteAime($aime);
            }
        } catch (Exception $ex) {

            foreach ($commentaire as $commentaires) {
                $repositoryCommentaire->deleteCommentaire($commentaire);
            }
            $em->persist($materiel);
            $em->flush();
            $em->getConnection()->commit();
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel) {
        $em = $this->_em;
        $materiel->setStatut(1);
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($materiel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel) {
        $em = $this->_em;
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($materiel);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function filtreMaterielBy($genres, $marques, $types, $proprietaires, $localisations) {
        $q = $this->createQueryBuilder('m');
        $q->where("true = true");
        if ($genres) {
			$q->join("m.genre", "genre");
            foreach ($genres as $idgenre) {
                $query = 'genre.id = :id' . $idgenre;
                $q->andwhere($query)
					->setParameter("id" . $idgenre, $idgenre);
            }
        }
        if ($marques) {
			$q->join("m.type", 't');
			$q->join("t.marque", 'marque');
            foreach ($marques as $idmarque) {
                $query = 'marque.id = :id' . $idmarque;
                $q->andwhere($query)
					->setParameter("id" . $idmarque, $idmarque);
            }
        }
        if ($types) {
            foreach ($types as $idtype) {
				$q->join("m.type", 'type');
                $query = 'type.id = :id' . $idtype;
                $q->andwhere($query)
                    ->setParameter("id" . $idtype, $idtype);
            }
        }
        if ($proprietaires) {
            foreach ($proprietaires as $idproprietaire) {
				$q->join("m.proprietaire", 'proprietaire');
                $query = 'proprietaire.id = :id' . $idproprietaire;
                $q->andwhere($query)
                        ->setParameter("id" . $idproprietaire, $idproprietaire);
            }
        }
        if ($localisations) {
            $i = 0;
            foreach ($localisations as $localisation) {
				$q->join("m.localisation", 'localisation');
                $query = 'localisation.ville = :ville' . $i;
                $q->andwhere($query)
                        ->setParameter("ville" . $i, $localisation);
                $i++;
            }
        }
        return $q->getQuery()->getResult();
    }

}
