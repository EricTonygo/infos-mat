<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anomalie
 *
 * @ORM\Table(name="anomalie")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\AnomalieRepository")
 */
class Anomalie extends Maintenancecorrective
{	
	/**
     * @var string
     *
     * @ORM\Column(name="disfonconstates", type="text", nullable=true)
     */
    private $disfonconstates;
	
	/**
     * @var string
     *
     * @ORM\Column(name="causeseventuelles", type="text", nullable=true)
     */
    private $causeseventuelles;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="anomalies", cascade={"persist"})
     * 
     */
    private $operations;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Test", inversedBy="anomalies", cascade={"persist"})
     * 
     */
    private $tests;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Question", inversedBy="anomalies", cascade={"persist"})
     * 
     */
    private $questions;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set disfonconstates
     *
     * @param string $disfonconstates
     * @return Anomalie
     */
    public function setDisfonconstates($disfonconstates)
    {
        $this->disfonconstates = $disfonconstates;

        return $this;
    }

    /**
     * Get disfonconstates
     *
     * @return string 
     */
    public function getDisfonconstates()
    {
        return $this->disfonconstates;
    }
	
	/**
     * Set causeseventuelles
     *
     * @param string $causeseventuelles
     * @return Anomalie
     */
    public function setCauseseventuelles($causeseventuelles)
    {
        $this->causeseventuelles = $causeseventuelles;

        return $this;
    }

    /**
     * Get causeseventuelles
     *
     * @return string 
     */
    public function getCauseseventuelles()
    {
        return $this->causeseventuelles;
    }
    
    
    /**
     * Add operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation 
     * @return Anomalie
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
     * @return Anomalie
     */
    public function setOperations(\Doctrine\Common\Collections\Collection $operations = null) {
        $this->operations = $operations;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation
     * @return Anomalie
     */
    public function removeOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $this->operations->removeElement($operation);
        return $this;
    }

    /**
     * Add question
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Question $question 
     * @return Anomalie
     */
    public function addQuestion(\NNGenie\MaintenanceBundle\Entity\Question $question) {
        $this->questions[] = $question;
        return $this;
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions() {
        return $this->questions;
    }

    /**
     * Set questions
     *
     * @param \Doctrine\Common\Collections\Collection $questions
     * @return Anomalie
     */
    public function setQuestions(\Doctrine\Common\Collections\Collection $questions = null) {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Question $question
     * @return Anomalie
     */
    public function removeQuestion(\NNGenie\MaintenanceBundle\Entity\Question $question) {
        $this->questions->removeElement($question);
        return $this;
    }

    /**
     * Add test
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Test $test 
     * @return Anomalie
     */
    public function addTest(\NNGenie\MaintenanceBundle\Entity\Test $test) {
        $this->tests[] = $test;
        return $this;
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests() {
        return $this->tests;
    }

    /**
     * Set tests
     *
     * @param \Doctrine\Common\Collections\Collection $tests
     * @return Anomalie
     */
    public function setTests(\Doctrine\Common\Collections\Collection $tests = null) {
        $this->tests = $tests;

        return $this;
    }

    /**
     * Remove test
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Test $test
     * @return Anomalie
     */
    public function removeTest(\NNGenie\MaintenanceBundle\Entity\Test $test) {
        $this->tests->removeElement($test);
        return $this;
    }
}
