<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\ProduitRepository")
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Controlematinal", mappedBy="produits", cascade={"persist"})
     */
    private $controlesmatinaux;
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", mappedBy="produits", cascade={"persist"})
     */
    private $operations;
    
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

    function getControlesmatinaux() {
        return $this->controlesmatinaux;
    }

    function getOperations() {
        return $this->operations;
    }

    function setControlesmatinaux(\Doctrine\Common\Collections\Collection $controlesmatinaux) {
        $this->controlesmatinaux = $controlesmatinaux;
        return $this;
    }

    function setOperations(\Doctrine\Common\Collections\Collection $operations) {
        $this->operations = $operations;
        return $this;
    }



}
