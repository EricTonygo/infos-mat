<?php

namespace NNGenie\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conditionformation
 *
 * @ORM\Table(name="conditionformation", indexes={@ORM\Index(name="fk_conditionFormation_formation1_idx", columns={"formation_id"})})
 * @ORM\Entity(repositoryClass="NNGenie\FormationBundle\Repository\ConditionformationRepository")
 */
class Conditionformation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="diplome", type="string", length=255, nullable=true)
     */
    private $diplome;

    /**
     * @var integer
     *
     * @ORM\Column(name="agelimite", type="integer", nullable=true)
     */
    private $agelimite;

    /**
     * @var string
     *
     * @ORM\Column(name="origine", type="string", length=255, nullable=true)
     */
    private $origine;

    /**
     * @var string
     *
     * @ORM\Column(name="experience", type="text", length=65535, nullable=true)
     */
    private $experience;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formation_id", referencedColumnName="id")
     * })
     */
    private $formation;

        
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
     * Set statut
     *
     * @param integer $statut
     * @return Conditionformation
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set diplome
     *
     * @param string $diplome
     * @return Conditionformation
     */
    public function setDiplome($diplome)
    {
        $this->diplome = $diplome;

        return $this;
    }

    /**
     * Get diplome
     *
     * @return string 
     */
    public function getDiplome()
    {
        return $this->diplome;
    }

    /**
     * Set agelimite
     *
     * @param integer $agelimite
     * @return Conditionformation
     */
    public function setAgelimite($agelimite)
    {
        $this->agelimite = $agelimite;

        return $this;
    }

    /**
     * Get agelimite
     *
     * @return integer 
     */
    public function getAgelimite()
    {
        return $this->agelimite;
    }

    /**
     * Set origine
     *
     * @param string $origine
     * @return Conditionformation
     */
    public function setOrigine($origine)
    {
        $this->origine = $origine;

        return $this;
    }

    /**
     * Get origine
     *
     * @return string 
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * Set experience
     *
     * @param string $experience
     * @return Conditionformation
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return string 
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set formation
     *
     * @param \NNGenie\FormationBundle\Entity\Formation $formation
     * @return Conditionformation
     */
    public function setFormation(\NNGenie\FormationBundle\Entity\Formation $formation = null)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return \NNGenie\FormationBundle\Entity\Formation 
     */
    public function getFormation()
    {
        return $this->formation;
    }
}
