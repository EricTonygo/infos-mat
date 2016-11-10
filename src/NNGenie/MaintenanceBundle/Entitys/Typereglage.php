<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typereglage
 *
 * @ORM\Table(name="typereglage")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\TypereglageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Typereglage
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
     * @ORM\OneToMany(targetEntity="NNGenie\MaintenanceBundle\Entity\Reglage", mappedBy="typereglage", cascade={"remove", "persist"})
     */
    private $reglages;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
         $this->reglages = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add reglage
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Reglage $reglage 
     * @return Typereglage
     */
    public function addReglage(\NNGenie\MaintenanceBundle\Entity\Reglage $reglage) {
        $this->reglages[] = $reglage;
        return $this;
    }

    /**
     * Get reglages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReglages() {
        return $this->reglages;
    }

    /**
     * Set reglages
     *
     * @param \Doctrine\Common\Collections\Collection $reglages
     * @return Typereglage
     */
    public function setReglages(\Doctrine\Common\Collections\Collection $reglages = null) {
        $this->reglages = $reglages;

        return $this;
    }

    /**
     * Remove reglage
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Reglage $reglage
     * @return Typereglage
     */
    public function removeReglage(\NNGenie\MaintenanceBundle\Entity\Reglage $reglage) {
        $this->reglages->removeElement($reglage);
        return $this;
    }

}
