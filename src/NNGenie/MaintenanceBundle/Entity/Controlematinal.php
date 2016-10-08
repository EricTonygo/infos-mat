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
     * @ORM\JoinTable(name="controlematinalproduit",
     *   joinColumns={
     *     @ORM\JoinColumn(name="controlematinal", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="produit", referencedColumnName="id")
     *   }
     * )
     */
    private $produits;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

}
