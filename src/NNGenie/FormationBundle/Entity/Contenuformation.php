<?php

namespace NNGenie\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contenuformation
 *
 * @ORM\Table(name="contenuformation", indexes={@ORM\Index(name="fk_contenuFormation_typeFormation1_idx", columns={"typeFormation_id"})})
 * @ORM\Entity(repositoryClass="NNGenie\FormationBundle\Repository\ContenuformationRepository")
 */
class Contenuformation
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;

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
     * @return Contenuformation
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
     * @return Contenuformation
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
     * Set details
     *
     * @param string $details
     * @return Contenuformation
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set typeformation
     *
     * @param \NNGenie\FormationBundle\Entity\Typeformation $typeformation
     * @return Contenuformation
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
}
