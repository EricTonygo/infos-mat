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
interface ITypeformationRepository {
    //put your code here
    public function deleteTypeformation(\NNGenie\FormationBundle\Entity\Typeformation $typeformation);

    public function saveTypeformation(\NNGenie\FormationBundle\Entity\Typeformation $typeformation);

    public function updateTypeformation(\NNGenie\FormationBundle\Entity\Typeformation $typeformation);
}
