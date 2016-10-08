<?php

namespace NNGenie\InfosMatBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Panne
 *
 * @ORM\Table(name="panne")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\PanneRepository")
 */
class Panne
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
