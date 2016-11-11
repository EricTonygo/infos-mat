<?php

namespace NNGenie\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coutformation
 *
 * @ORM\Table(name="coutformation", indexes={@ORM\Index(name="fk_coutFormation_formation1_idx", columns={"formation_id"})})
 * @ORM\Entity(repositoryClass="NNGenie\FormationBundle\Repository\CoutformationRepository")
 */
class Coutformation
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
     * @var integer
     *
     * @ORM\Column(name="salle", type="bigint", nullable=true)
     */
    private $salle;

    /**
     * @var integer
     *
     * @ORM\Column(name="hebergement", type="bigint", nullable=true)
     */
    private $hebergement;

    /**
     * @var integer
     *
     * @ORM\Column(name="transport", type="bigint", nullable=true)
     */
    private $transport;

    /**
     * @var integer
     *
     * @ORM\Column(name="documentation", type="bigint", nullable=true)
     */
    private $documentation;

    /**
     * @var integer
     *
     * @ORM\Column(name="secretariat", type="bigint", nullable=true)
     */
    private $secretariat;

    /**
     * @var integer
     *
     * @ORM\Column(name="didactique", type="bigint", nullable=true)
     */
    private $didactique;

    /**
     * @var integer
     *
     * @ORM\Column(name="fraishonoraire", type="bigint", nullable=true)
     */
    private $fraishonoraire;

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
     * @return Coutformation
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
     * Set salle
     *
     * @param integer $salle
     * @return Coutformation
     */
    public function setSalle($salle)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get salle
     *
     * @return integer 
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * Set hebergement
     *
     * @param integer $hebergement
     * @return Coutformation
     */
    public function setHebergement($hebergement)
    {
        $this->hebergement = $hebergement;

        return $this;
    }

    /**
     * Get hebergement
     *
     * @return integer 
     */
    public function getHebergement()
    {
        return $this->hebergement;
    }

    /**
     * Set transport
     *
     * @param integer $transport
     * @return Coutformation
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Get transport
     *
     * @return integer 
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Set documentation
     *
     * @param integer $documentation
     * @return Coutformation
     */
    public function setDocumentation($documentation)
    {
        $this->documentation = $documentation;

        return $this;
    }

    /**
     * Get documentation
     *
     * @return integer 
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * Set secretariat
     *
     * @param integer $secretariat
     * @return Coutformation
     */
    public function setSecretariat($secretariat)
    {
        $this->secretariat = $secretariat;

        return $this;
    }

    /**
     * Get secretariat
     *
     * @return integer 
     */
    public function getSecretariat()
    {
        return $this->secretariat;
    }

    /**
     * Set didactique
     *
     * @param integer $didactique
     * @return Coutformation
     */
    public function setDidactique($didactique)
    {
        $this->didactique = $didactique;

        return $this;
    }

    /**
     * Get didactique
     *
     * @return integer 
     */
    public function getDidactique()
    {
        return $this->didactique;
    }

    /**
     * Set fraishonoraire
     *
     * @param integer $fraishonoraire
     * @return Coutformation
     */
    public function setFraishonoraire($fraishonoraire)
    {
        $this->fraishonoraire = $fraishonoraire;

        return $this;
    }

    /**
     * Get fraishonoraire
     *
     * @return integer 
     */
    public function getFraishonoraire()
    {
        return $this->fraishonoraire;
    }

    /**
     * Set formation
     *
     * @param \NNGenie\FormationBundle\Entity\Formation $formation
     * @return Coutformation
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
