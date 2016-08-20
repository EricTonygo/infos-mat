<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\GenreRepository")
 */
class Genre
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
     * @var \Famille
     *
     * @ORM\ManyToOne(targetEntity="Famille", inversedBy="genres")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="famille", referencedColumnName="id")
     * })
     */
    private $famille;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Marque", mappedBy="genres")
     */
    private $marques;
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
        $this->marques = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Genre
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
     * @return Genre
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
     * Set famille
     *
     * @param \NNGenie\InfosMatBundle\Entity\Famille $famille
     * @return Genre
     */
    public function setFamille(\NNGenie\InfosMatBundle\Entity\Famille $famille = null)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return \NNGenie\InfosMatBundle\Entity\Famille 
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Add marque
     *
     * @param \NNGenie\InfosMatBundle\Entity\Marque $marque
     * @return Genre
     */
    public function addMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque)
    {
        $this->marques[] = $marque;

        return $this;
    }

    /**
     * Remove marque
     *
     * @param \NNGenie\InfosMatBundle\Entity\Marque $marque
     */
    public function removeMarque(\NNGenie\InfosMatBundle\Entity\Marque $marque)
    {
        $this->marques->removeElement($marque);
    }

    /**
     * Get marques
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMarques()
    {
        return $this->marques;
    }
    
    /**
     * Set 
     *
     * @param \Doctrine\Common\Collections\Collection $marques
     * @return \User
     */
    public function setMarques(\Doctrine\Common\Collections\Collection $marques = null)
    {
        $this->marques = $marques;

        return $this;
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
}
