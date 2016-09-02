<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marque
 *
 * @ORM\Table(name="marque")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\MarqueRepository")
 */
class Marque
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="marques")
     * @ORM\JoinTable(name="marquegenre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="marque", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="genre", referencedColumnName="id")
     *   }
     * )
     */
    private $genres;
    
    /**
    * @ORM\OneToMany(targetEntity="Type", mappedBy="marque", cascade={"remove", "persist"})
    */
    private $types;

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
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Marque
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
     * Add genre
     *
     * @param \NNGenie\InfosMatBundle\Entity\Genre $genre
     * @return Marque
     */
    public function addGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \NNGenie\InfosMatBundle\Entity\Genre $genre
     */
    public function removeGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genre
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
     * @return Marque
     */
    public function setGenres(\Doctrine\Common\Collections\Collection $genres = null)
    {
        $this->genres = $genres;

        return $this;
    }
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Marque
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
     * Add type
     *
     * @param \NNGenie\InfosMatBundle\Entity\Type $type 
     * @return Marque
     */
    public function addType(\NNGenie\InfosMatBundle\Entity\Type $type)
    {
        $this->types[] = $type;
        return $this;
    }
    
    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypes()
    {
        return $this->types;
    }
    
    /**
     * Set types
     *
     * @param \Doctrine\Common\Collections\Collection $types
     * @return Marque
     */
    public function setTypes(\Doctrine\Common\Collections\Collection $types = null)
    {
        $this->types = $types;

        return $this;
    }
    
    /**
     * Remove type
     *
     * \NNGenie\InfosMatBundle\Entity\Type $type
	 * @return Marque
     */
    public function removeType(\NNGenie\InfosMatBundle\Entity\Type $type)
    {
        $this->types->removeElement($type);
		return $this;
    }
}
