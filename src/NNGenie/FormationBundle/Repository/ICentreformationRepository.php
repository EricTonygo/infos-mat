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
interface ICentreformationRepository {
    //put your code here
    public function deleteCentreformation(\NNGenie\FormationBundle\Entity\Centreformation $centreformation);

    public function saveCentreformation(\NNGenie\FormationBundle\Entity\Centreformation $centreformation);

    public function updateCentreformation(\NNGenie\FormationBundle\Entity\Centreformation $centreformation);
}
