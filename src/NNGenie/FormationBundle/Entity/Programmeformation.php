<?php

namespace NNGenie\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programmeformation
 *
 * @ORM\Table(name="programmeformation", indexes={@ORM\Index(name="fk_programmeFormation_formation1_idx", columns={"formation_id"})})
 * @ORM\Entity(repositoryClass="NNGenie\FormationBundle\Repository\ProgrammeformationRepository")
 */
class Programmeformation
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
     * @ORM\Column(name="dureetheo", type="string", length=255, nullable=true)
     */
    private $dureetheo;

    /**
     * @var string
     *
     * @ORM\Column(name="dureeprati", type="string", length=255, nullable=true)
     */
    private $dureeprati;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbreaprenant", type="integer", nullable=true)
     */
    private $nbreaprenant;

    /**
     * @var string
     *
     * @ORM\Column(name="totaltemppratiq", type="string", length=255, nullable=true)
     */
    private $totaltemppratiq;

    /**
     * @var string
     *
     * @ORM\Column(name="totalenseign", type="string", length=255, nullable=true)
     */
    private $totalenseign;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrejourlibre", type="integer", nullable=true)
     */
    private $nbrejourlibre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="datetime", nullable=true)
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetime", nullable=true)
     */
    private $fin;

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
     * @return Programmeformation
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
     * Set dureetheo
     *
     * @param string $dureetheo
     * @return Programmeformation
     */
    public function setDureetheo($dureetheo)
    {
        $this->dureetheo = $dureetheo;

        return $this;
    }

    /**
     * Get dureetheo
     *
     * @return string 
     */
    public function getDureetheo()
    {
        return $this->dureetheo;
    }

    /**
     * Set dureeprati
     *
     * @param string $dureeprati
     * @return Programmeformation
     */
    public function setDureeprati($dureeprati)
    {
        $this->dureeprati = $dureeprati;

        return $this;
    }

    /**
     * Get dureeprati
     *
     * @return string 
     */
    public function getDureeprati()
    {
        return $this->dureeprati;
    }

    /**
     * Set nbreaprenant
     *
     * @param integer $nbreaprenant
     * @return Programmeformation
     */
    public function setNbreaprenant($nbreaprenant)
    {
        $this->nbreaprenant = $nbreaprenant;

        return $this;
    }

    /**
     * Get nbreaprenant
     *
     * @return integer 
     */
    public function getNbreaprenant()
    {
        return $this->nbreaprenant;
    }

    /**
     * Set totaltemppratiq
     *
     * @param string $totaltemppratiq
     * @return Programmeformation
     */
    public function setTotaltemppratiq($totaltemppratiq)
    {
        $this->totaltemppratiq = $totaltemppratiq;

        return $this;
    }

    /**
     * Get totaltemppratiq
     *
     * @return string 
     */
    public function getTotaltemppratiq()
    {
        return $this->totaltemppratiq;
    }

    /**
     * Set totalenseign
     *
     * @param string $totalenseign
     * @return Programmeformation
     */
    public function setTotalenseign($totalenseign)
    {
        $this->totalenseign = $totalenseign;

        return $this;
    }

    /**
     * Get totalenseign
     *
     * @return string 
     */
    public function getTotalenseign()
    {
        return $this->totalenseign;
    }

    /**
     * Set nbrejourlibre
     *
     * @param integer $nbrejourlibre
     * @return Programmeformation
     */
    public function setNbrejourlibre($nbrejourlibre)
    {
        $this->nbrejourlibre = $nbrejourlibre;

        return $this;
    }

    /**
     * Get nbrejourlibre
     *
     * @return integer 
     */
    public function getNbrejourlibre()
    {
        return $this->nbrejourlibre;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     * @return Programmeformation
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime 
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Programmeformation
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set formation
     *
     * @param \NNGenie\FormationBundle\Entity\Formation $formation
     * @return Programmeformation
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
