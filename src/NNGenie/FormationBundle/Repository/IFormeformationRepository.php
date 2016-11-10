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
interface IFormeformationRepository {
    //put your code here
    public function deleteFormeformation(\NNGenie\FormationBundle\Entity\Formeformation $formeformation);

    public function saveFormeformation(\NNGenie\FormationBundle\Entity\Formeformation $formeformation);

    public function updateFormeformation(\NNGenie\FormationBundle\Entity\Formeformation $formeformation);
}
