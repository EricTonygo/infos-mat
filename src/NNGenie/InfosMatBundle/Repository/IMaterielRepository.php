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
interface IMaterielRepository {
    //put your code here
    public function deleteMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel);

    public function saveMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel);

    public function updateMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel);
    
    //public function filtreMaterielBy($genres, $marques, $types, $proprietaires, $localisations);
}
