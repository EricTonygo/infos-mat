<?php

namespace NNGenie\MaintenanceBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Panne
 *
 * @ORM\Table(name="panne")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\PanneRepository")
 */
class Panne extends \NNGenie\MaintenanceBundle\Entity\Maintenancecorrective
{
    
    /**
     * @var string
     *
     * @ORM\Column(name="actions", type="text", nullable=true)
     */
    private $actions;
    
    /**
     * @var string
     *
     * @ORM\Column(name="causeseventuelles", type="text", nullable=true)
     */
    private $causeseventuelles;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
   
    
    public function getActions() {
        return $this->actions;
    }

    public function getCauseseventuelles() {
        return $this->causeseventuelles;
    }

    public function setActions($actions) {
        $this->actions = $actions;
        return $this;
    }

    public function setCauseseventuelles($causeseventuelles) {
        $this->causeseventuelles = $causeseventuelles;
        return $this;
    }


}
