<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ImageRepository
 *
 * @author TONYE
 */
class ImageRepository extends EntityRepository implements IImageRepository{
    //put your code here
    
    
    public function deleteImage(\NNGenie\InfosMatBundle\Entity\Image $image) {
        $em= $this->_em;
        $image->setStatut(0);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($image);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function saveImage(\NNGenie\InfosMatBundle\Entity\Image $image) {
        $em= $this->_em;
        $image->setStatut(1);
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($image);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

    public function updateImage(\NNGenie\InfosMatBundle\Entity\Image $image) {
        $em= $this->_em;
        $em->getConnection()->beginTransaction();
        try{
            $em->persist($image);
            $em->flush();
            $em->getConnection()->commit();
        } catch (Exception $ex) {
            $em->getConnection()->rollback();
            $em->close();
            throw $ex;
        }
    }

}
