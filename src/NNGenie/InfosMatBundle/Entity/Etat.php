<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 *
 * @ORM\Table(name="etat")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\EtatRepository")
 */
class Etat
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
     * @var integer
     *
     * @ORM\Column(name="nbreetoile", type="integer", nullable=true)
     */
    private $nbreetoile;
    
    /**
    * @ORM\OneToMany(targetEntity="Materiel", mappedBy="etat", cascade={"remove", "persist"})
    */
    private $materiels;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->nbreetoile=0;
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
     * @return Etat
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
     * @return Etat
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get nbreetoile
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->nbreetoile;
    }
    
    /**
     * Set nbreetoile
     *
     * @param integer $nbreetoile
     * @return Etat
     */
    public function setNbreetoile($nbreetoile)
    {
        $this->nbreetoile = $nbreetoile;

        return $this;
    }

    /**
     * Get nbreetoile
     *
     * @return integer 
     */
    public function getNbreetoile()
    {
        return $this->nbreetoile;
    }
    
    /**
     * Add materiel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Materiel $materiel 
     * @return Etat
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
     * @return Etat
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
	 * @return Etat
     */
    public function removeMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel)
    {
        $this->materiels->removeElement($materiel);
		return $this;
    }
}
