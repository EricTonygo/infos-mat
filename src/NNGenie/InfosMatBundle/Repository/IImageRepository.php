<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\InfosMatBundle\Repository;

/**
 *
 * @author TONYE
 */
interface IImageRepository {
    //put your code here
    public function deleteImage(\NNGenie\InfosMatBundle\Entity\Image $image);

    public function saveImage(\NNGenie\InfosMatBundle\Entity\Image $image);

    public function updateImage(\NNGenie\InfosMatBundle\Entity\Image $image);
}
