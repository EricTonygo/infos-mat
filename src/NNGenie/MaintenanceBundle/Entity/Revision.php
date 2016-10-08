<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Revision
 *
 * @ORM\Table(name="revision")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\RevisionRepository")
 */
class Revision
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
     * Set description
     *
     * @param string $description
     * @return Revision
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set daterevision
     *
     * @param \DateTime $daterevision
     * @return Revision
     */
    public function setDaterevision($daterevision)
    {
        $this->daterevision = $daterevision;

        return $this;
    }

    /**
     * Get daterevision
     *
     * @return \DateTime 
     */
    public function getDaterevision()
    {
        return $this->daterevision;
    }

    /**
     * Set materiel
     *
     * @param \NNGenie\InfosMatBundle\Entity\Materiel $materiel
     * @return Revision
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
     * Set user
     *
     * @param \NNGenie\InfosMatBundle\Entity\User $user
     * @return Revision
     */
    public function setUser(\NNGenie\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NNGenie\InfosMatBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Revision
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
