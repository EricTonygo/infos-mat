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
    
}
