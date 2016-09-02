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
interface IAdresseRepository {
    //put your code here
    public function deleteAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse);

    public function saveAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse);

    public function updateAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse);
}
