<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultat
 *
 * @ORM\Table(name="resultat")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\ResultatRepository")
 */
class Resultat
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
     * @var \Test
     *
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test", referencedColumnName="id")
     * })
     */
    private $test;
    

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
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Resultat
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }
    
    public function getIntitule() {
        return $this->intitule;
    }

    public function setIntitule($intitule) {
        $this->intitule = $intitule;
        return $this;
    }
    
    function getTest() {
        return $this->test;
    }

    function setTest(Test $test) {
        $this->test = $test;
    }
}
