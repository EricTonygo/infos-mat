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
     * @var \Typereglage
     *
     * @ORM\ManyToOne(targetEntity="Typereglage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typereglage", referencedColumnName="id")
     * })
     */
    private $typereglage;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="propretes")
     * 
     */
    private $operations;
    
    function getTypereglage() {
        return $this->typereglage;
    }

    function setTypereglage(\Typereglage $typereglage) {
        $this->typereglage = $typereglage;
    }


}
