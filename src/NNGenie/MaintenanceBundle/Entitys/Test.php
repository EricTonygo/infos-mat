<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\TestRepository")
 */
class Test
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Panne", mappedBy="tests", cascade={"remove", "persist"})
     */
    private $pannes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Anomalie", mappedBy="tests", cascade={"remove", "persist"})
     */
    private $anomalies;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
    * @ORM\OneToMany(targetEntity="Resultat", mappedBy="test", cascade={"remove", "persist"})
    */
    private $resultats;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->pannes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->anomalies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->resultats = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Test
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get unite
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->unite;
    }  
    
    function getIntitule() {
        return $this->intitule;
    }

    function getPannes() {
        return $this->pannes;
    }

    function getAnomalies() {
        return $this->anomalies;
    }

    function setIntitule($intitule) {
        $this->intitule = $intitule;
    }

    function setPannes(\Doctrine\Common\Collections\Collection $pannes) {
        $this->pannes = $pannes;
        return $this;
    }

    function setAnomalies(\Doctrine\Common\Collections\Collection $anomalies) {
        $this->anomalies = $anomalies;
        return $this;
    }

    function getResultats() {
        return $this->resultats;
    }

    function setResultats(\Doctrine\Common\Collections\Collection $resultats) {
        $this->resultats = $resultats;
        return $this;
    }


}
