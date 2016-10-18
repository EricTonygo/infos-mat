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
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="entretienperiodiques")
     * 
     */
    private $operations;
}
