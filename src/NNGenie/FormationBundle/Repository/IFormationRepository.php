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
interface IFormationRepository {
    //put your code here
    public function deleteFormation(\NNGenie\FormationBundle\Entity\Formation $formation);

    public function saveFormation(\NNGenie\FormationBundle\Entity\Formation $formation);

    public function updateFormation(\NNGenie\FormationBundle\Entity\Formation $formation);
}
