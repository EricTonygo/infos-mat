<?php
namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Controlematinal
 *
 * @ORM\Table(name="controlematinal")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\ControlematinalRepository")
 */
class Controlematinal extends Maintenancepreventive {

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produit", inversedBy="controlematinaux", cascade={"persist"})
     */
    private $produits;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Operation", inversedBy="controlematinaux", cascade={"persist"})
     * 
     */
    private $operations;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->produits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add produit
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Produit $produit 
     * @return Controlematinal
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
     * @return Controlematinal
     */
    public function setProduits(\Doctrine\Common\Collections\Collection $produits = null) {
        $this->produits = $produits;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Produit $produit
     * @return Controlematinal
     */
    public function removeProduit(\NNGenie\MaintenanceBundle\Entity\Produit $produit) {
        $this->produits->removeElement($produit);
        return $this;
    }

    /**
     * Add operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation 
     * @return Controlematinal
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
     * @return Controlematinal
     */
    public function setOperations(\Doctrine\Common\Collections\Collection $operations = null) {
        $this->operations = $operations;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \NNGenie\MaintenanceBundle\Entity\Operation $operation
     * @return Controlematinal
     */
    public function removeOperation(\NNGenie\MaintenanceBundle\Entity\Operation $operation) {
        $this->operations->removeElement($operation);
        return $this;
    }

}
