<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entretienperiodique
 *
 * @ORM\Table(name="entretienperiodique")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\EntretienperiodiqueRepository")
 */
class Entretienperiodique extends Maintenancepreventive
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="entretienperiodiques", cascade={"persist"})
     * 
     */
    private $operations;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation 
     * @return Entretienperiodique
     */
    public function addOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $this->operations[] = $operation;
        return $this;
    }

    /**
     * Get operations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperations() {
        return $this->operations;
    }

    /**
     * Set operations
     *
     * @param \Doctrine\Common\Collections\Collection $operations
     * @return Entretienperiodique
     */
    public function setOperations(\Doctrine\Common\Collections\Collection $operations = null) {
        $this->operations = $operations;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation
     * @return Entretienperiodique
     */
    public function removeOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $this->operations->removeElement($operation);
        return $this;
    }
}
