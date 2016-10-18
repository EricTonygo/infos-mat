<?php

namespace NNGenie\MaintenanceBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Panne
 *
 * @ORM\Table(name="panne")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\PanneRepository")
 */
class Panne extends \NNGenie\MaintenanceBundle\Entity\Maintenancecorrective
{
    
    /**
     * @var string
     *
     * @ORM\Column(name="actions", type="text", nullable=true)
     */
    private $actions;
    
    /**
     * @var string
     *
     * @ORM\Column(name="causeseventuelles", type="text", nullable=true)
     */
    private $causeseventuelles;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Piece", inversedBy="pannes")
     * 
     */
    private $pieces;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="pannes")
     * 
     */
    private $operations;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Test", inversedBy="pannes")
     * 
     */
    private $tests;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Question", inversedBy="pannes")
     * 
     */
    private $questions;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->pieces = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getActions() {
        return $this->actions;
    }

    public function getCauseseventuelles() {
        return $this->causeseventuelles;
    }

    public function setActions($actions) {
        $this->actions = $actions;
        return $this;
    }

    public function setCauseseventuelles($causeseventuelles) {
        $this->causeseventuelles = $causeseventuelles;
        return $this;
    }

    /**
     * Add piece
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Piece $piece 
     * @return Panne
     */
    public function addPiece(\NNGenie\MaintenanceBundle\Entity\Piece $piece)
    {
        $this->pieces[] = $piece;
        return $this;
    }
    
    /**
     * Get pieces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPieces()
    {
        return $this->pieces;
    }
    
    /**
     * Set pieces
     *
     * @param \Doctrine\Common\Collections\Collection $pieces
     * @return Panne
     */
    public function setPieces(\Doctrine\Common\Collections\Collection $pieces = null)
    {
        $this->pieces = $pieces;

        return $this;
    }
    
    /**
     * Remove piece
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Piece $piece
	 * @return Panne
     */
    public function removePiece(\NNGenie\MaintenanceBundle\Entity\Piece $piece)
    {
        $this->pieces->removeElement($piece);
		return $this;
    }
    
    
    /**
     * Add operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation 
     * @return Panne
     */
    public function addOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation)
    {
        $this->operations[] = $operation;
        return $this;
    }
    
    /**
     * Get operations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperations()
    {
        return $this->operations;
    }
    
    /**
     * Set operations
     *
     * @param \Doctrine\Common\Collections\Collection $operations
     * @return Panne
     */
    public function setOperations(\Doctrine\Common\Collections\Collection $operations = null)
    {
        $this->operations = $operations;

        return $this;
    }
    
    /**
     * Remove operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation
	 * @return Panne
     */
    public function removeOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation)
    {
        $this->operations->removeElement($operation);
		return $this;
    }
    
    /**
     * Add question
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Question $question 
     * @return Panne
     */
    public function addQuestion(\NNGenie\MaintenanceBundle\Entity\Question $question)
    {
        $this->questions[] = $question;
        return $this;
    }
    
    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
    
    /**
     * Set questions
     *
     * @param \Doctrine\Common\Collections\Collection $questions
     * @return Panne
     */
    public function setQuestions(\Doctrine\Common\Collections\Collection $questions = null)
    {
        $this->questions = $questions;

        return $this;
    }
    
    /**
     * Remove question
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Question $question
	 * @return Panne
     */
    public function removeQuestion(\NNGenie\MaintenanceBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
		return $this;
    }
    
    /**
     * Add test
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Test $test 
     * @return Panne
     */
    public function addTest(\NNGenie\MaintenanceBundle\Entity\Test $test)
    {
        $this->tests[] = $test;
        return $this;
    }
    
    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests()
    {
        return $this->tests;
    }
    
    /**
     * Set tests
     *
     * @param \Doctrine\Common\Collections\Collection $tests
     * @return Panne
     */
    public function setTests(\Doctrine\Common\Collections\Collection $tests = null)
    {
        $this->tests = $tests;

        return $this;
    }
    
    /**
     * Remove test
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Test $test
     * @return Panne
     */
    public function removeTest(\NNGenie\MaintenanceBundle\Entity\Test $test)
    {
        $this->tests->removeElement($test);
		return $this;
    }   
}
