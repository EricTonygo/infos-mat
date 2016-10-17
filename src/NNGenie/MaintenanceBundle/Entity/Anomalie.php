<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anomalie
 *
 * @ORM\Table(name="anomalie")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\AnomalieRepository")
 */
class Anomalie extends Maintenancecorrective
{	
	/**
     * @var string
     *
     * @ORM\Column(name="disfonconstates", type="text", nullable=true)
     */
    private $disfonconstates;
	
	/**
     * @var string
     *
     * @ORM\Column(name="causeseventuelles", type="text", nullable=true)
     */
    private $causeseventuelles;
	
	/**
     * Set disfonconstates
     *
     * @param string $disfonconstates
     * @return Anomalie
     */
    public function setDisfonconstates($disfonconstates)
    {
        $this->disfonconstates = $disfonconstates;

        return $this;
    }

    /**
     * Get disfonconstates
     *
     * @return string 
     */
    public function getDisfonconstates()
    {
        return $this->disfonconstates;
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
