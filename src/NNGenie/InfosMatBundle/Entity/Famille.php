<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Famille
 *
 * @ORM\Table(name="famille")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\FamilleRepository")
 */
class Famille
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
     * @var \Classemateriel
     *
     * @ORM\ManyToOne(targetEntity="Classemateriel", inversedBy="familles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classeMateriel", referencedColumnName="id")
     * })
     */
    private $classemateriel;

    /**
    * @ORM\OneToMany(targetEntity="Genre", mappedBy="famille", cascade={"remove", "persist"})
    */
    private $genres;

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
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Famille
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
     * @return Famille
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
     * Set classemateriel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel
     * @return Famille
     */
    public function setClassemateriel(\NNGenie\InfosMatBundle\Entity\Classemateriel $classemateriel = null)
    {
        $this->classemateriel = $classemateriel;

        return $this;
    }

    /**
     * Get classemateriel
     *
     * @return \NNGenie\InfosMatBundle\Entity\Classemateriel 
     */
    public function getClassemateriel()
    {
        return $this->classemateriel;
    }
    
    /**
     * Add genre
     *
     * @param \NNGenie\InfosMatBundle\Entity\Genre $genre 
     * @return Famille
     */
    public function addGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;
        return $this;
    }
    
    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }
    
    /**
     * Set genres
     *
     * @param \Doctrine\Common\Collections\Collection $genres
     * @return \Famille
     */
    public function setGenres(\Doctrine\Common\Collections\Collection $genres = null)
    {
        $this->genres = $genres;

        return $this;
    }
    
    /**
     * Remove genre
     *
     * @param \NNGenie\InfosMatBundle\Entity\Genre $genre
	 * @return Famille
     */
    public function removeGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
		return $this;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Famille
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
