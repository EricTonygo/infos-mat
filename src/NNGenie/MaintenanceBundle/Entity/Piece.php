<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\TypeRepository")
 */
class Type
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
     * @var \Marque
     *
     * @ORM\ManyToOne(targetEntity="Marque", inversedBy="types")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marque", referencedColumnName="id")
     * })
     */
    private $marque;

    
    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
    * @ORM\OneToMany(targetEntity="Materiel", mappedBy="type", cascade={"remove", "persist"})
    */
    private $materiels;
	
	/**
    * @ORM\OneToMany(targetEntity="Donneetechniquetype", mappedBy="type", cascade={"remove", "persist"})
    */
    private $donneetechniquetypes;

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
     * Set nom
     *
     * @param string $nom
     * @return Type
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set marque
     *
     * @param \NNGenie\InfosMatBundle\Entity\Marque $marque
     * @return Type
     */
    public function setMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque = null)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \NNGenie\InfosMatBundle\Entity\Marque 
     */
    public function getMarque()
    {
        return $this->marque;
    }
	
	/**
     * Set statut
     *
     * @param integer $statut
     * @return Type
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
     * Add materiel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Materiel $materiel 
     * @return \Type
     */
    public function addMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel)
    {
        $this->materiels[] = $materiel;
        return $this;
    }
    
    /**
     * Get materiels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMateriels()
    {
        return $this->materiels;
    }
    
    /**
     * Set materiels
     *
     * @param \Doctrine\Common\Collections\Collection $materiels
     * @return Type
     */
    public function setMateriels(\Doctrine\Common\Collections\Collection $materiels = null)
    {
        $this->materiels = $materiels;

        return $this;
    }
    
    /**
     * Remove materiel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Materiel $materiel
     * @return Type
     */
    public function removeMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel)
    {
        $this->materiels->removeElement($materiel);
		return $this;
    }
	
	/**
     * Add donneetechniquetype
     *
     * @param \NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype 
     * @return Type
     */
    public function addDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype)
    {
        $this->donneetechniquetypes[] = $donneetechniquetype;
        return $this;
    }
    
    /**
     * Get donneetechniquetypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDonneetechniquetypes()
    {
        return $this->donneetechniquetypes;
    }
    
    /**
     * Set donneetechniquetypes
     *
     * @param \Doctrine\Common\Collections\Collection $donneetechniquetypes
     * @return \Type
     */
    public function setDonneetechniquetypes(\Doctrine\Common\Collections\Collection $donneetechniquetypes = null)
    {
        $this->donneetechniquetypes = $donneetechniquetypes;

        return $this;
    }
    
    /**
     * Remove donneetechniquetype
     *
     * @param \NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype
	 * @return \Type
     */
    public function removeDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype)
    {
        $this->donneetechniquetypes->removeElement($donneetechniquetype);
		return $this;
    }
}
