<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donneetechnique
 *
 * @ORM\Table(name="donneetechnique")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\DonneetechniqueRepository")
 */
class Donneetechnique
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
     * @var string
     *
     * @ORM\Column(name="unite", type="string", length=255, nullable=true)
     */
    private $unite;
    
    /**
    * @ORM\OneToMany(targetEntity="Donneetechniquetype", mappedBy="donneetechnique", cascade={"remove", "persist"})
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
     * @return Donneetechnique
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
     * Set statut
     *
     * @param integer $statut
     * @return Donneetechnique
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get unite
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->unite;
    }
    
    /**
     * Set unite
     *
     * @param string $unite
     * @return Donneetechnique
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * Get unite
     *
     * @return string 
     */
    public function getUnite()
    {
        return $this->unite;
    }
	
	/**
     * Add donneetechniquetype
     *
     * @param \NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype 
     * @return Donneetechnique
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
     * @return \Donneetechnique
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
	 * @return \Donneetechnique
     */
    public function removeDonneetechniquetype(\NNGenie\InfosMatBundle\Entity\Donneetechniquetype $donneetechniquetype)
    {
        $this->donneetechniquetypes->removeElement($donneetechniquetype);
		return $this;
    }
}
