<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NNGenie\FormationBundle\Repository;

/**
 *
 * @author TONYE
 */
interface ICoutformationRepository {
    //put your code here
    public function deleteCoutformation(\NNGenie\FormationBundle\Entity\Coutformation $coutformation);

    public function saveCoutformation(\NNGenie\FormationBundle\Entity\Coutformation $coutformation);

    public function updateCoutformation(\NNGenie\FormationBundle\Entity\Coutformation $coutformation);
}
