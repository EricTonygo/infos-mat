<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Piece
 *
 * @ORM\Table(name="piece")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\PieceRepository")
 */
class Piece
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Maintenancecorrective", mappedBy="pieces")
     */
    private $maintenancecorrectives;
    
    /**
     * @var NNGenie\InfosMatBundle\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="NNGenie\InfosMatBundle\Entity\Type")
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
     * @return Piece
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
    
    public function getMaintenancecorrectives() {
        return $this->maintenancecorrectives;
    }

    public function getType() {
        return $this->type;
    }

    public function setMaintenancecorrectives(\Doctrine\Common\Collections\Collection $maintenancecorrectives) {
        $this->maintenancecorrectives = $maintenancecorrectives;
        return $this;
    }

    public function setType(NNGenie\InfosMatBundle\Entity\Type $type) {
        $this->type = $type;
        return $this;
    }


}
