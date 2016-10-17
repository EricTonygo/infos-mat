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
interface IDonneetechniquetypeRepository {
    //put your code here
    public function deleteDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype);

    public function saveDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype);

    public function updateDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype);
}
