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
}
