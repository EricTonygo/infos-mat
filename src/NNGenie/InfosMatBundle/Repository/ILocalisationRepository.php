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
interface ILocalisationRepository {
    //put your code here
    public function deleteLocalisation(\NNGenie\InfosMatBundle\Entity\Localisation $localisation);

    public function saveLocalisation(\NNGenie\InfosMatBundle\Entity\Localisation $localisation);

    public function updateLocalisation(\NNGenie\InfosMatBundle\Entity\Localisation $localisation);
}
