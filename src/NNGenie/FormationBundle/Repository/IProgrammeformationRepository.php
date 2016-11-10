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
interface IProgrammeformationRepository {
    //put your code here
    public function deleteProgrammeformation(\NNGenie\FormationBundle\Entity\Programmeformation $programmeformation);

    public function saveProgrammeformation(\NNGenie\FormationBundle\Entity\Programmeformation $programmeformation);

    public function updateProgrammeformation(\NNGenie\FormationBundle\Entity\Programmeformation $programmeformation);
}
