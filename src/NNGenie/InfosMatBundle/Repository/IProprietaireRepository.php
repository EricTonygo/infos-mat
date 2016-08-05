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
interface IProprietaireRepository{
    //put your code here
    public function deleteProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire);

    public function saveProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire);

    public function updateProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire);
}
