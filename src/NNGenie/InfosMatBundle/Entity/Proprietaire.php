<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proprietaire
 *
 * @ORM\Table(name="proprietaire")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\ProprietaireRepository")
 */
class Proprietaire
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
     * @var \Adresse 
     * @ORM\OneToOne(targetEntity="Adresse",cascade={"persist"})
     * @ORM\JoinColumn(name="adresse", referencedColumnName="id")
     */
    private $adresse;
    
    /**
    * @ORM\OneToMany(targetEntity="Materiel", mappedBy="proprietaire", cascade={"remove", "persist"})
    */
    private $materiels;

    
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

    /**
     * Set nom
     *
     * @param string $nom
     * @return Proprietaire
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
     * @return Proprietaire
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
     * @return Actualite
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
     * @return Proprietaire
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
     * @return Proprietaire
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
     * @return Proprietaire
     */
    public function removeMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel)
    {
        $this->materiels->removeElement($materiel);
		return $this;
    }
}
