<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 *@ORM\MappedSuperclass()
 */
class Maintenancecorrective extends Maintenance
{    
    /**
     * @var \Organe
     *
     * @ORM\ManyToOne(targetEntity="Organe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="organe", referencedColumnName="id")
     * })
     */
    private $organe;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Piece", inversedBy="maintenancecorrectives")
     * 
     */
    private $pieces;
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Question", inversedBy="maintenancecorrectives")
     * 
     */
    private $questions;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Test", inversedBy="maintenancecorrectives")
     * 
     */
    private $tests;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->pieces = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
    * Set organe
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Organe $organe
     * @return Maintenancecorrective
     */
    public function setOrgane(\NNGenie\MaintenanceBundle\Entity\Organe $organe = null)
    {
        $this->organe = $organe;

        return $this;
    }

    /**
     * Get organe
     *
     * @return \NNGenie\MaintenanceBundle\Entity\Organe 
     */
    public function getOrgane()
    {
        return $this->organe;
    }
}
