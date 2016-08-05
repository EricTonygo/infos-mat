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
interface ITypeRepository {
    //put your code here
    public function deleteType(\NNGenie\InfosMatBundle\Entity\Type $type);

    public function saveType(\NNGenie\InfosMatBundle\Entity\Type $type);

    public function updateType(\NNGenie\InfosMatBundle\Entity\Type $type);
}
