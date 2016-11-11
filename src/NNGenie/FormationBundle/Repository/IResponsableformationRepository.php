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
interface IResponsableformationRepository {
    //put your code here
    public function deleteResponsableformation(\NNGenie\FormationBundle\Entity\Responsableformation $responsableformation);

    public function saveResponsableformation(\NNGenie\FormationBundle\Entity\Responsableformation $responsableformation);

    public function updateResponsableformation(\NNGenie\FormationBundle\Entity\Responsableformation $responsableformation);
}
