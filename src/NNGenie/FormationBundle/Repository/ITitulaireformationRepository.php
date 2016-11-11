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
interface ITitulaireformationRepository {
    //put your code here
    public function deleteTitulaireformation(\NNGenie\FormationBundle\Entity\Titulaireformation $titulaireformation);

    public function saveTitulaireformation(\NNGenie\FormationBundle\Entity\Titulaireformation $titulaireformation);

    public function updateTitulaireformation(\NNGenie\FormationBundle\Entity\Titulaireformation $titulaireformation);
}
