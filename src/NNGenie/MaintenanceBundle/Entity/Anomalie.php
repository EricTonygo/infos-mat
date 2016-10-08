<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anomalie
 *
 * @ORM\Table(name="anomalie")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Repository\AnomalieRepository")
 */
class Anomalie
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
     * @ORM\Column(name="disfonConstates", type="text", nullable=true)
     */
    private $disfonConstates;
	
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
	
	/**
     * Set disfonConstates
     *
     * @param string $disfonConstates
     * @return Anomalie
     */
    public function setDisfonConstates($disfonConstates)
    {
        $this->disfonConstates = $disfonConstates;

        return $this;
    }

    /**
     * Get disfonConstates
     *
     * @return string 
     */
    public function getDisfonConstates()
    {
        return $this->disfonConstates;
    }
	
	/**
     * Set causeseventuelles
     *
     * @param string $causeseventuelles
     * @return Anomalie
     */
    public function setCauseseventuelles($causeseventuelles)
    {
        $this->causeseventuelles = $causeseventuelles;

        return $this;
    }

    /**
     * Get causeseventuelles
     *
     * @return string 
     */
    public function getCauseseventuelles()
    {
        return $this->causeseventuelles;
    }
}
