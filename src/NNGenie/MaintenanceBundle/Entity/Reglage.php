<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reglage
 *
 * @ORM\Table(name="fournisseur")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\ReglageRepository")
 */
class Reglage
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
     * @return Reglage
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
     * Set adresse
     *
     * @param \NNGenie\InfosMatBundle\Entity\Adresse $adresse
     * @return Reglage
     */
    public function setAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \NNGenie\InfosMatBundle\Entity\Adresse 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Reglage
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
     * @return Reglage
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
     * @return Reglage
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
     * @return Reglage
     */
    public function removeMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel)
    {
        $this->materiels->removeElement($materiel);
		return $this;
    }
}
