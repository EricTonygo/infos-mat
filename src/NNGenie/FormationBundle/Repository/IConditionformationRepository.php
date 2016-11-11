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
interface IConditionformationRepository {
    //put your code here
    public function deleteConditionformation(\NNGenie\FormationBundle\Entity\Conditionformation $conditionformation);

    public function saveConditionformation(\NNGenie\FormationBundle\Entity\Conditionformation $conditionformation);

    public function updateConditionformation(\NNGenie\FormationBundle\Entity\Conditionformation $conditionformation);
}
