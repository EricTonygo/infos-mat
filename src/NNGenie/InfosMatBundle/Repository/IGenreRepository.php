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
interface IGenreRepository {
    //put your code here
    public function deleteGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre);

    public function saveGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre);

    public function updateGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre);
}
