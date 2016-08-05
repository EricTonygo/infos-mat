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
interface IMarqueRepository {
    //put your code here
    public function deleteMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque);

    public function saveMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque);

    public function updateMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque);
}
