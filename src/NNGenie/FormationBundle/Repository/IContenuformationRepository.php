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
interface IContenuformationRepository {
    //put your code here
    public function deleteContenuformation(\NNGenie\FormationBundle\Entity\Contenuformation $contenuformation);

    public function saveContenuformation(\NNGenie\FormationBundle\Entity\Contenuformation $contenuformation);

    public function updateContenuformation(\NNGenie\FormationBundle\Entity\Contenuformation $contenuformation);
}
