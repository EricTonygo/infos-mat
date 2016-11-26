<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typeproprete
 *
 * @ORM\Table(name="typeproprete")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\TypepropreteRepository")
 */
class Typeproprete
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
     * @ORM\OneToMany(targetEntity="NNGenie\MaintenanceBundle\Entity\Proprete", mappedBy="typeproprete", cascade={"remove", "persist"})
     */
    private $propretes;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
         $this->propretes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Typeproprete
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
    
    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }
    
    /**
     * Add proprete
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Proprete $proprete 
     * @return Typeproprete
     */
    public function addProprete(\NNGenie\MaintenanceBundle\Entity\Proprete $proprete) {
        $this->propretes[] = $proprete;
        return $this;
    }

    /**
     * Get propretes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropretes() {
        return $this->propretes;
    }

    /**
     * Set propretes
     *
     * @param \Doctrine\Common\Collections\Collection $propretes
     * @return Typeproprete
     */
    public function setPropretes(\Doctrine\Common\Collections\Collection $propretes = null) {
        $this->propretes = $propretes;

        return $this;
    }

    /**
     * Remove proprete
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Proprete $proprete
     * @return Typeproprete
     */
    public function removeProprete(\NNGenie\MaintenanceBundle\Entity\Proprete $proprete) {
        $this->propretes->removeElement($proprete);
        return $this;
    }
    
}
