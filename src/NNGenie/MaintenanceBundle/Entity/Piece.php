<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Piece
 *
 * @ORM\Table(name="piece")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\PieceRepository")
 */
class Piece
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", piece="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="statut", piece="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Maintenancecorrective", mappedBy="pieces")
     */
    private $maintenancecorrectives;

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
}
