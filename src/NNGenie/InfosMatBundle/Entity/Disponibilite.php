<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disponibilite
 *
 * @ORM\Table(name="disponibilite")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Entity\Repository\DisponibiliteRepository")
 */
class Disponibilite
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
    * @ORM\OneToMany(targetEntity="Disponibilitemateriel", mappedBy="diponibilite", cascade={"remove", "persist"})
    */
    private $disponibilitemateriels;

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
        $this->disponibilitemateriels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Disponibilite
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
     * Add disponibilitemateriel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel 
     * @return User
     */
    public function addDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel)
    {
        $this->disponibilitemateriels[] = $disponibilitemateriel;
        return $this;
    }
    
    /**
     * Get disponibilitemateriels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisponibilitemateriels()
    {
        return $this->disponibilitemateriels;
    }
    
    /**
     * Set disponibilitemateriels
     *
     * @param \Doctrine\Common\Collections\Collection $disponibilitemateriels
     * @return \User
     */
    public function setDisponibilitemateriels(\Doctrine\Common\Collections\Collection $disponibilitemateriels = null)
    {
        $this->disponibilitemateriels = $disponibilitemateriels;

        return $this;
    }
    
    /**
     * Remove disponibilitemateriel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel
     */
    public function removeDisponibilitemateriel(\NNGenie\InfosMatBundle\Entity\Disponibilitemateriel $disponibilitemateriel)
    {
        $this->disponibilitemateriels->removeElement($disponibilitemateriel);
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
}
