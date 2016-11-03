<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Piece
 *
 * @ORM\Table(name="piece")
 * @ORM\Entity(repositoryClass="\NNGenie\MaintenanceBundle\Repository\PieceRepository")
 */
class Piece
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
     * @ORM\ManyToMany(targetEntity="Panne", mappedBy="pieces", cascade={"persist"})
     */
    private $pannes;
    
    /**
     * @var \NNGenie\InfosMatBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="\NNGenie\InfosMatBundle\Entity\Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->pannes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set statut
     *
     * @param integer $statut
     * @return Piece
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

    public function getType() {
        return $this->type;
    }

    public function setType(\NNGenie\InfosMatBundle\Entity\Type $type) {
        $this->type = $type;
        return $this;
    }


    function getNom() {
        return $this->nom;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }
    
    /**
     * Get pannes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPannes() {
        return $this->pannes;
    }

    /**
     * Set pannes
     *
     * @param \Doctrine\Common\Collections\Collection $pannes
     * @return Piece
     */
    public function setPannes(\Doctrine\Common\Collections\Collection $pannes = null) {
        $this->pannes = $pannes;

        return $this;
    }


}
