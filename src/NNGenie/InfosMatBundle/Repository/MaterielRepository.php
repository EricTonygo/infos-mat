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
            foreach ($genres as $idgenre) {
                $query = "'m.genre.id = :" . "id" . $idgenre . "'";
                $q->andwhere($query)
                        ->setParameter("id" . $idgenre, $idgenre);
            }
        }
        if ($marques) {
            foreach ($marques as $idmarque) {
                $query = "'m.marque.id = :" . "id" . $idmarque . "'";
                $q->andwhere($query)
                        ->setParameter("id" . $idmarque, $idmarque);
            }
        }
        if ($types) {
            foreach ($types as $idtype) {
                $query = "'m.type.id = :" . "id" . $idtype . "'";
                $q->andwhere($query)
                        ->setParameter("id" . $idtype, $idtype);
            }
        }
        if ($proprietaires) {
            foreach ($proprietaires as $idproprietaire) {
                $query = "'m.proprietaire.id = :" . "id" . $idproprietaire . "'";
                $q->andwhere($query)
                        ->setParameter("id" . $idproprietaire, $idproprietaire);
            }
        }
        if ($localisations) {
            foreach ($localisations as $idlocalisation) {
                $query = "'m.localisation.id = :" . "id" . $idlocalisation . "'";
                $q->andwhere($query)
                        ->setParameter("id" . $idlocalisation, $idlocalisation);
            }
        }

        return $q->getQuery()->getResult();
    }

}
