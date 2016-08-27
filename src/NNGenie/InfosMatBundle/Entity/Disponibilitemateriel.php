<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Disponibilitemateriel
 *
 * @ORM\Table(name="disponibilitemateriel")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\DisponibilitematerielRepository")
 */
class Disponibilitemateriel
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime", nullable=true)
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime", nullable=true)
     */
    private $datefin;

    /**
     * @var \Disponibilite
     *
     * @ORM\ManyToOne(targetEntity="Disponibilite", inversedBy="disponibilitemateriels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="disponibilite", referencedColumnName="id")
     * })
     */
    private $disponibilite;

    /**
     * @var \Materiel 
     * @ORM\OneToOne(targetEntity="Materiel")
     * @ORM\JoinColumn(name="materiel", referencedColumnName="id")
     */
    private $materiel;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="encours", type="integer", nullable=true)
     */
    private $encours;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->encours = 1;
        $this->datedebut = new \Datetime();
        $this->datefin = new \Datetime();
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
     * Set datedebut
     *
     * @param \DateTime $datedebut
     * @return Disponibilitemateriel
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime 
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     * @return Disponibilitemateriel
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime 
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set disponibilite
     *
     * @param \NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite
     * @return Disponibilitemateriel
     */
    public function setDisponibilite(\NNGenie\InfosMatBundle\Entity\Disponibilite $disponibilite = null)
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * Get disponibilite
     *
     * @return \NNGenie\InfosMatBundle\Entity\Disponibilite 
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * Set materiel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Materiel $materiel
     * @return Disponibilitemateriel
     */
    public function setMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel = null)
    {
        $this->materiel = $materiel;

        return $this;
    }

    /**
     * Get materiel
     *
     * @return \NNGenie\InfosMatBundle\Entity\Materiel 
     */
    public function getMateriel()
    {
        return $this->materiel;
    }
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Disponibilitemateriel
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
