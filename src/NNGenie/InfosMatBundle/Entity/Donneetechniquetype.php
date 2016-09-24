<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donneetechniquetype
 *
 * @ORM\Table(name="donneetechniquetype")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\DonneetechniquetypeRepository")
 */
class Donneetechniquetype
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
     * @var \Donneetechnique
     *
     * @ORM\ManyToOne(targetEntity="Donneetechnique", inversedBy="donneetechniquetypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="donneetechnique", referencedColumnName="id")
     * })
     */
    private $donneetechnique;

    /**
     * @var \Type
     *
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="donneetechniquetypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
	/**
     * @var float
     *
     * @ORM\Column(name="valeur", type="float", precision=10, scale=0, nullable=true)
     */
    private $valeur;

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

    /**
     * Set donneetechnique
     *
     * @param \NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique
     * @return Donneetechniquetype
     */
    public function setDonneetechnique(\NNGenie\InfosMatBundle\Entity\Donneetechnique $donneetechnique = null)
    {
        $this->donneetechnique = $donneetechnique;

        return $this;
    }

    /**
     * Get donneetechnique
     *
     * @return \NNGenie\InfosMatBundle\Entity\Donneetechnique 
     */
    public function getDonneetechnique()
    {
        return $this->donneetechnique;
    }

    /**
     * Set type
     *
     * @param \NNGenie\InfosMatBundle\Entity\Type $type
     * @return Donneetechniquetype
     */
    public function setType(\NNGenie\InfosMatBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \NNGenie\InfosMatBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Donneetechniquetype
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }
	
	/**
     * Set valeur
     *
     * @param float $valeur
     * @return Materiel
     */
    public function setPrix($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->valeur;
    }
}
