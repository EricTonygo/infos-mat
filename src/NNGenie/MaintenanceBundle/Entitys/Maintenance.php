<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 *@ORM\MappedSuperclass()
 */
class Maintenance
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
     * @var \NNGenie\InfosMatBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="\NNGenie\InfosMatBundle\Entity\Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;
    
    
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
     * Set statut
     *
     * @param integer $statut
     * @return Maintenance
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
     * Set type
     *
     * @param \NNGenie\InfosMatBundle\Entity\Type $type
     * @return Maintenancecorrective
     */
    public function setType(\NNGenie\InfosMatBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \NNGenie\InfosMatBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }
    
    function getNom() {
        return $this->nom;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }


}
