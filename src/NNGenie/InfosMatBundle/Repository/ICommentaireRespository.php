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
interface ICommentaireRespository {
    //put your code here
    public function deleteCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire);

    public function saveCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire);

    public function updateCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire);
}
