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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
