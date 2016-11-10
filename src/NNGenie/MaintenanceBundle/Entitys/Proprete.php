<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proprete
 *
 * @ORM\Table(name="proprete")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\PropreteRepository")
 */
class Proprete extends Maintenance

{
    /**
     * @var \Typeproprete
     *
     * @ORM\ManyToOne(targetEntity="Typeproprete")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeproprete", referencedColumnName="id")
     * })
     */
    private $typeproprete;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="propretes", cascade={"persist"})
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

    function getTypeproprete() {
        return $this->typeproprete;
    }

    function setTypeproprete(Typeproprete $typeproprete) {
        $this->typeproprete = $typeproprete;
        return $this;
    }


    
}
