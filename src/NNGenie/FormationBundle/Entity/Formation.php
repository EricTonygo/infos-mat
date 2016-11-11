<?php

namespace NNGenie\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="formation", uniqueConstraints={@ORM\UniqueConstraint(name="nom_UNIQUE", columns={"nom"})}, indexes={@ORM\Index(name="fk_formation_formeFormation_idx", columns={"formeFormation_id"}), @ORM\Index(name="fk_formation_centreFormation1_idx", columns={"centreFormation_id"}), @ORM\Index(name="fk_formation_typeFormation1_idx", columns={"typeFormation_id"})})
 * @ORM\Entity(repositoryClass="NNGenie\FormationBundle\Repository\FormationRepository")
 */
class Formation
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="cible", type="string", length=255, nullable=true)
     */
    private $cible;

    /**
     * @var string
     *
     * @ORM\Column(name="objectifprincip", type="text", nullable=true)
     */
    private $objectifprincip;

    /**
     * @var string
     *
     * @ORM\Column(name="objectifsecond", type="text", nullable=true)
     */
    private $objectifsecond;

    /**
     * @var \Formeformation
     *
     * @ORM\ManyToOne(targetEntity="Formeformation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formeFormation_id", referencedColumnName="id")
     * })
     */
    private $formeformation;

    /**
     * @var \Centreformation
     *
     * @ORM\ManyToOne(targetEntity="Centreformation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="centreFormation_id", referencedColumnName="id")
     * })
     */
    private $centreformation;

    /**
     * @var \Typeformation
     *
     * @ORM\ManyToOne(targetEntity="Typeformation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeFormation_id", referencedColumnName="id")
     * })
     */
    private $typeformation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Responsableformation", inversedBy="idformation")
     * @ORM\JoinTable(name="formation_responsableformation",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idformation", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idresponsable", referencedColumnName="id")
     *   }
     * )
     */
    private $idresponsable;

    
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
        $this->idresponsable = new \Doctrine\Common\Collections\ArrayCollection();
    }

      
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Formation
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
     * Set nom
     *
     * @param string $nom
     * @return Formation
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
     * Set date
     *
     * @param \DateTime $date
     * @return Formation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set cible
     *
     * @param string $cible
     * @return Formation
     */
    public function setCible($cible)
    {
        $this->cible = $cible;

        return $this;
    }

    /**
     * Get cible
     *
     * @return string 
     */
    public function getCible()
    {
        return $this->cible;
    }

    /**
     * Set objectifprincip
     *
     * @param string $objectifprincip
     * @return Formation
     */
    public function setObjectifprincip($objectifprincip)
    {
        $this->objectifprincip = $objectifprincip;

        return $this;
    }

    /**
     * Get objectifprincip
     *
     * @return string 
     */
    public function getObjectifprincip()
    {
        return $this->objectifprincip;
    }

    /**
     * Set objectifsecond
     *
     * @param string $objectifsecond
     * @return Formation
     */
    public function setObjectifsecond($objectifsecond)
    {
        $this->objectifsecond = $objectifsecond;

        return $this;
    }

    /**
     * Get objectifsecond
     *
     * @return string 
     */
    public function getObjectifsecond()
    {
        return $this->objectifsecond;
    }

    /**
     * Set formeformation
     *
     * @param \NNGenie\FormationBundle\Entity\Formeformation $formeformation
     * @return Formation
     */
    public function setFormeformation(\NNGenie\FormationBundle\Entity\Formeformation $formeformation = null)
    {
        $this->formeformation = $formeformation;

        return $this;
    }

    /**
     * Get formeformation
     *
     * @return \NNGenie\FormationBundle\Entity\Formeformation 
     */
    public function getFormeformation()
    {
        return $this->formeformation;
    }

    /**
     * Set centreformation
     *
     * @param \NNGenie\FormationBundle\Entity\Centreformation $centreformation
     * @return Formation
     */
    public function setCentreformation(\NNGenie\FormationBundle\Entity\Centreformation $centreformation = null)
    {
        $this->centreformation = $centreformation;

        return $this;
    }

    /**
     * Get centreformation
     *
     * @return \NNGenie\FormationBundle\Entity\Centreformation 
     */
    public function getCentreformation()
    {
        return $this->centreformation;
    }

    /**
     * Set typeformation
     *
     * @param \NNGenie\FormationBundle\Entity\Typeformation $typeformation
     * @return Formation
     */
    public function setTypeformation(\NNGenie\FormationBundle\Entity\Typeformation $typeformation = null)
    {
        $this->typeformation = $typeformation;

        return $this;
    }

    /**
     * Get typeformation
     *
     * @return \NNGenie\FormationBundle\Entity\Typeformation 
     */
    public function getTypeformation()
    {
        return $this->typeformation;
    }

    /**
     * Add idresponsable
     *
     * @param \NNGenie\FormationBundle\Entity\Responsableformation $idresponsable
     * @return Formation
     */
    public function addIdresponsable(\NNGenie\FormationBundle\Entity\Responsableformation $idresponsable)
    {
        $this->idresponsable[] = $idresponsable;

        return $this;
    }

    /**
     * Remove idresponsable
     *
     * @param \NNGenie\FormationBundle\Entity\Responsableformation $idresponsable
     */
    public function removeIdresponsable(\NNGenie\FormationBundle\Entity\Responsableformation $idresponsable)
    {
        $this->idresponsable->removeElement($idresponsable);
    }

    /**
     * Get idresponsable
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdresponsable()
    {
        return $this->idresponsable;
    }
}
