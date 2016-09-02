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
interface IDisponibiliteRepository {
    //put your code here
    public function deleteDisponibilite(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite);

    public function saveDisponibilite(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite);

    public function updateDisponibilite(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite);
}
