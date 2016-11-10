<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operation
 *
 * @ORM\Table(name="operation")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\OperationRepository")
 */
class Operation
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;
    
    /**
     * @var \Procede
     *
     * @ORM\ManyToOne(targetEntity="Procede")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="procede", referencedColumnName="id")
     * })
     */
    private $procede;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produit", inversedBy="operations", cascade={"persist"})
     * 
     */
    private $produits;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Panne", mappedBy="operations", cascade={"persist"})
     */
    private $pannes;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Anomalie", mappedBy="operations", cascade={"persist"})
     */
    private $anomalies;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Reglage", inversedBy="operations", cascade={"persist"})
     * 
     */
    private $reglages;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Revision", inversedBy="operations", cascade={"persist"})
     * 
     */
    private $revisions;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Entretienperiodique", inversedBy="operations", cascade={"persist"})
     * 
     */
    private $entretiensperiodiques;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Controlematinal", inversedBy="operations", cascade={"persist"})
     * 
     */
    private $controlesmatinaux;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Proprete", inversedBy="operations", cascade={"persist"})
     * 
     */
    private $propretes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->produits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pannes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->anomalies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->revisions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reglages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entretiensperiodiques = new \Doctrine\Common\Collections\ArrayCollection();
        $this->controlesmatinaux = new \Doctrine\Common\Collections\ArrayCollection();
        $this->propretes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return Operation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
     * Set statut
     *
     * @param integer $statut
     * @return Actualite
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
    
    public function getProcede() {
        return $this->procede;
    }

    public function setProcede(Procede $procede) {
        $this->procede = $procede;
        return $this;
    }
    

    function getPannes() {
        return $this->pannes;
    }

    function getAnomalies() {
        return $this->anomalies;
    }

    function getReglages() {
        return $this->reglages;
    }

    function getRevisions() {
        return $this->revisions;
    }

    function getEntretiensperiodiques() {
        return $this->entretiensperiodiques;
    }
    
    function getPropretes() {
        return $this->propretes;
    }

    function getControlesmatinaux() {
        return $this->controlesmatinaux;
    }

    function setPannes(\Doctrine\Common\Collections\Collection $pannes) {
        $this->pannes = $pannes;
        return $this;
    }

    function setAnomalies(\Doctrine\Common\Collections\Collection $anomalies) {
        $this->anomalies = $anomalies;
    }

    function setReglages(\Doctrine\Common\Collections\Collection $reglages) {
        $this->reglages = $reglages;
        return $this;
    }

    function setRevisions(\Doctrine\Common\Collections\Collection $revisions) {
        $this->revisions = $revisions;
        return $this;
    }

    function setEntretiensperiodiques(\Doctrine\Common\Collections\Collection $entretiensperiodiques) {
        $this->entretiensperiodiques = $entretiensperiodiques;
        return $this;
    }

    function setControlesmatinaux(\Doctrine\Common\Collections\Collection $controlesmatinaux) {
        $this->controlesmatinaux = $controlesmatinaux;
        return $this;
    }
    
    function setProprete(\Doctrine\Common\Collections\Collection $propretes) {
        $this->propretes = $propretes;
        return $this;
    }

    /**
     * Add produit
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Produit $produit 
     * @return Operation
     */
    public function addProduit(\NNGenie\MaintenanceBundle\Entity\Produit $produit) {
        $this->produits[] = $produit;
        return $this;
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits() {
        return $this->produits;
    }

    /**
     * Set produits
     *
     * @param \Doctrine\Common\Collections\Collection $produits
     * @return Operation
     */
    public function setProduits(\Doctrine\Common\Collections\Collection $produits = null) {
        $this->produits = $produits;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Produit $produit
     * @return Operation
     */
    public function removeProduit(\NNGenie\MaintenanceBundle\Entity\Produit $produit) {
        $this->produits->removeElement($produit);
        return $this;
    }

}
