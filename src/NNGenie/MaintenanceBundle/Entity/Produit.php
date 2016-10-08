<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\ProduitRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getNom() {
        return $this->nom;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }


}
