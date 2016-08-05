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
interface IClassematerielRepository {
    //put your code here
    public function deleteClassemateriel(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel);

    public function saveClassemateriel(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel);

    public function updateClassemateriel(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel);
}
