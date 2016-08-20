<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aime
 *
 * @ORM\Table(name="aime")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\AimeRepository")
 */
class Aime
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
     * @var \Materiel
     *
     * @ORM\ManyToOne(targetEntity="Materiel", inversedBy="aimes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="materiel", referencedColumnName="id")
     * })
     */
    private $materiel;

    /**
     * @var \NNGenie\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\NNGenie\UserBundle\Entity\User", inversedBy="aimes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set materiel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Materiel $materiel
     * @return Aime
     */
    public function setMateriel(\NNGenie\InfosMatBundle\Entity\Materiel $materiel = null)
    {
        $this->materiel = $materiel;

        return $this;
    }

    /**
     * Get materiel
     *
     * @return NNGenie\InfosMatBundle\Entity\Materiel 
     */
    public function getMateriel()
    {
        return $this->materiel;
    }

    /**
     * Set user
     *
     * @param NNGenie\UserBundle\Entity\User $user
     * @return Aime
     */
    public function setUser(\NNGenie\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return NNGenie\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
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
