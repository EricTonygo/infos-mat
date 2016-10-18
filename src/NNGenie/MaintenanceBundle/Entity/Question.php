<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="intitule", type="text", nullable=true)
     */
    private $intitule;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Panne", mappedBy="questions")
     */
    private $pannes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Anomalie", mappedBy="questions")
     */
    private $anomalies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
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

    public function getIntitule() {
        return $this->intitule;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setIntitule($intitule) {
        $this->intitule = $intitule;
        return $this;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    function getMaintenancecorrectives() {
        return $this->maintenancecorrectives;
    }

    function setMaintenancecorrectives(\Doctrine\Common\Collections\Collection $maintenancecorrectives) {
        $this->maintenancecorrectives = $maintenancecorrectives;
    }


    
}
