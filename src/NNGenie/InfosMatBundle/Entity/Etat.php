<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 *
 * @ORM\Table(name="etat")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\EtatRepository")
 */
class Etat
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
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbreetoile", type="integer", nullable=true)
     */
    private $nbreetoile;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->nbreetoile=0;
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
     * @return Etat
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
     * Get nbreetoile
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->nbreetoile;
    }
    
    /**
     * Set nbreetoile
     *
     * @param integer $nbreetoile
     * @return Actualite
     */
    public function setNbreetoile($nbreetoile)
    {
        $this->nbreetoile = $nbreetoile;

        return $this;
    }

    /**
     * Get nbreetoile
     *
     * @return integer 
     */
    public function getNbreetoile()
    {
        return $this->nbreetoile;
    }
}
