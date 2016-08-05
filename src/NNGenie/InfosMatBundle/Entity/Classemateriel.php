<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classemateriel
 *
 * @ORM\Table(name="classemateriel")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Entity\Repository\ClassematerielRepository")
 */
class Classemateriel
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
    * @ORM\OneToMany(targetEntity="Famille", mappedBy="classemateriel", cascade={"remove", "persist"})
    */
    private $familles;
    
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
        $this->familles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Classemateriel
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
     * Set code
     *
     * @param string $code
     * @return Classemateriel
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
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
     * Add famille
     *
     * @param \NNGenie\InfosMatBundle\Entity\Famille $famille 
     * @return User
     */
    public function addFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille)
    {
        $this->familles[] = $famille;
        return $this;
    }
    
    /**
     * Get familles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFamilles()
    {
        return $this->familles;
    }
    
    /**
     * Set familles
     *
     * @param \Doctrine\Common\Collections\Collection $familles
     * @return \User
     */
    public function setFamilles(\Doctrine\Common\Collections\Collection $familles = null)
    {
        $this->familles = $familles;

        return $this;
    }
    
    /**
     * Remove famille
     *
     * @param \NNGenie\InfosMatBundle\Entity\Famille $famille
     */
    public function removeFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille)
    {
        $this->familles->removeElement($famille);
    }
}
