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
interface IAimeRepository {
    //put your code here
    public function deleteAime(\NNGenie\InfosMatBundle\Entity\Aime $aime);

    public function saveAime(\NNGenie\InfosMatBundle\Entity\Aime $aime);

    public function updateAime(\NNGenie\InfosMatBundle\Entity\Aime $aime);
}
