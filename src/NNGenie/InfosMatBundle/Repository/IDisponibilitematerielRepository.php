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
interface IDisponibilitematerielRepository {
    //put your code here
    public function deleteDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel);

    public function saveDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel);

    public function updateDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel);
}
