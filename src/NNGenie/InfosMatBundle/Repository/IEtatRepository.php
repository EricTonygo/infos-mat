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
interface IEtatRepository {
    //put your code here
    public function deleteEtat(\NNGenie\InfosMatBundle\Entity\Etat $etat);

    public function saveEtat(\NNGenie\InfosMatBundle\Entity\Etat $etat);

    public function updateEtat(\NNGenie\InfosMatBundle\Entity\Etat $etat);
}
