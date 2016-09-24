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
interface IDonneetechniqueRepository {
    //put your code here
    public function deleteDonneetechnique(\NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique);

    public function saveDonneetechnique(\NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique);

    public function updateDonneetechnique(\NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique);
}
