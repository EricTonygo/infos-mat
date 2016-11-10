<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reglage
 *
 * @ORM\Table(name="reglage")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\ReglageRepository")
 */
class Reglage extends Maintenancepreventive
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="reglages")
     * 
     */
    private $operations;
    
    /**
     * @var \Typereglage
     *
     * @ORM\ManyToOne(targetEntity="Typereglage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typereglage", referencedColumnName="id")
     * })
     */
    private $typereglage;
    
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
     * @return Reglage
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
     * @return Reglage
     */
    public function setOperations(\Doctrine\Common\Collections\Collection $operations = null) {
        $this->operations = $operations;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation
     * @return Reglage
     */
    public function removeOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $this->operations->removeElement($operation);
        return $this;
    }
    
    function getTypereglage() {
        return $this->typereglage;
    }

    function setTypereglage(Typereglage $typereglage) {
        $this->typereglage = $typereglage;
        return $this;
    }


}
