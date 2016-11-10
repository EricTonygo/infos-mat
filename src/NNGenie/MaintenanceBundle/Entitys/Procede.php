<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Procede
 *
 * @ORM\Table(name="procede")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\ProcedeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Procede
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
     * @ORM\Column(name="intitule", type="string", length=255, nullable=true)
     */
    private $intitule;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     *  @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="NNGenie\MaintenanceBundle\Entity\Operation", mappedBy="procede", cascade={"remove", "persist"})
     */
    private $operations;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
         $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    public function getStatut() {
        return $this->statut;
    }
    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    
    public function getIntitule() {
        return $this->intitule;
    }

    public function setIntitule($intitule) {
        $this->intitule = $intitule;
        return $this;
    }
    
    /**
     * Add operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation 
     * @return Procede
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
     * @return Procede
     */
    public function setOperations(\Doctrine\Common\Collections\Collection $operations = null) {
        $this->operations = $operations;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation
     * @return Procede
     */
    public function removeOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $this->operations->removeElement($operation);
        return $this;
    }
}
