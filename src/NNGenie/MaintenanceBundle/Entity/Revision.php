<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Revision
 *
 * @ORM\Table(name="revision")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\RevisionRepository")
 */
class Revision extends Maintenance
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="revisions")
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
     * @return Revision
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
     * @return Revision
     */
    public function setOperations(\Doctrine\Common\Collections\Collection $operations = null) {
        $this->operations = $operations;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation
     * @return Revision
     */
    public function removeOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $this->operations->removeElement($operation);
        return $this;
    }
}
