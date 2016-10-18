<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Controlematinal
 *
 * @ORM\Table(name="controlematinal")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\ControlematinalRepository")
 */
class Controlematinal extends Maintenancepreventive
{
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produit", inversedBy="controlematinaux")
     */
    private $produits;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="controlematinaux")
     * 
     */
    private $operations;
    
    function getProduits() {
        return $this->produits;
    }

    function setProduits(\Doctrine\Common\Collections\Collection $produits) {
        $this->produits = $produits;
    }



}
