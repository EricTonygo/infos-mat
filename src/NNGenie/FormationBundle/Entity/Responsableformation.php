<?php

namespace NNGenie\FormationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Responsableformation
 *
 * @ORM\Table(name="responsableformation")
 * @ORM\Entity(repositoryClass="NNGenie\FormationBundle\Repository\ResponsableformationRepository")
 */
class Responsableformation
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="qualite", type="string", length=255, nullable=true)
     */
    private $qualite;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=255, nullable=true)
     */
    private $poste;

    /**
     * @var string
     *
     * @ORM\Column(name="experienceDomain", type="text", length=65535, nullable=true)
     */
    private $experiencedomain;

    /**
     * @var string
     *
     * @ORM\Column(name="experienceFormation", type="text", length=65535, nullable=true)
     */
    private $experienceformation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Formation", mappedBy="idresponsable")
     */
    private $idformation;

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
        $this->idformation = new \Doctrine\Common\Collections\ArrayCollection();
    }

      
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Responsableformation
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
     * @return Responsableformation
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
     * Set prenom
     *
     * @param string $prenom
     * @return Responsableformation
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set qualite
     *
     * @param string $qualite
     * @return Responsableformation
     */
    public function setQualite($qualite)
    {
        $this->qualite = $qualite;

        return $this;
    }

    /**
     * Get qualite
     *
     * @return string 
     */
    public function getQualite()
    {
        return $this->qualite;
    }

    /**
     * Set poste
     *
     * @param string $poste
     * @return Responsableformation
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string 
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set experiencedomain
     *
     * @param string $experiencedomain
     * @return Responsableformation
     */
    public function setExperiencedomain($experiencedomain)
    {
        $this->experiencedomain = $experiencedomain;

        return $this;
    }

    /**
     * Get experiencedomain
     *
     * @return string 
     */
    public function getExperiencedomain()
    {
        return $this->experiencedomain;
    }

    /**
     * Set experienceformation
     *
     * @param string $experienceformation
     * @return Responsableformation
     */
    public function setExperienceformation($experienceformation)
    {
        $this->experienceformation = $experienceformation;

        return $this;
    }

    /**
     * Get experienceformation
     *
     * @return string 
     */
    public function getExperienceformation()
    {
        return $this->experienceformation;
    }

    /**
     * Add idformation
     *
     * @param \NNGenie\FormationBundle\Entity\Formation $idformation
     * @return Responsableformation
     */
    public function addIdformation(\NNGenie\FormationBundle\Entity\Formation $idformation)
    {
        $this->idformation[] = $idformation;

        return $this;
    }

    /**
     * Remove idformation
     *
     * @param \NNGenie\FormationBundle\Entity\Formation $idformation
     */
    public function removeIdformation(\NNGenie\FormationBundle\Entity\Formation $idformation)
    {
        $this->idformation->removeElement($idformation);
    }

    /**
     * Get idformation
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdformation()
    {
        return $this->idformation;
    }
}
