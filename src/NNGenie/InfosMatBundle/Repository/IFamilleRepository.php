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
interface IFamilleRepository {
    //put your code here
    public function deleteFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille);

    public function saveFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille);

    public function updateFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille);
}
