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
interface IFournisseurRepository {
    //put your code here
    public function deleteFournisseur(\NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur);

    public function saveFournisseur(\NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur);

    public function updateFournisseur(\NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur);
}
