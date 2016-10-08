<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maintenancecorrective
 *
 * @ORM\Table(name="maintenancecorrective")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\MaintenancecorrectiveRepository")
 */
class Maintenancecorrective
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
     * Constructor
     */
    public function __construct()
    {
        
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

    
}
