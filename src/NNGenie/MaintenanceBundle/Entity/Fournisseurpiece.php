<?php

namespace NNGenie\MaintenanceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fournisseurpiece
 *
 * @ORM\Table(name="fournisseurpiece")
 * @ORM\Entity(repositoryClass="NNGenie\MaintenanceBundle\Repository\FournisseurpieceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Fournisseurpiece
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="NNGenie\InfosMatBundle\Entity\Type", inversedBy="fournisseurspieces", cascade={"persist"})
     */
    private $types;
    
    /**
     * @var \Adresse 
     * @ORM\OneToOne(targetEntity="NNGenie\InfosMatBundle\Entity\Adresse",cascade={"persist"})
     * @ORM\JoinColumn(name="adresse", referencedColumnName="id")
     */
    private $adresse;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    public function getNom() {
        return $this->nom;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
        return $this;
    }

    /**
     * Add type
     *
     * @param \NNGenie\InfosMatBundle\Entity\Type $type 
     * @return Fournisseurpiece
     */
    public function addType(\NNGenie\InfosMatBundle\Entity\Type $type) {
        $this->types[] = $type;
        return $this;
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypes() {
        return $this->types;
    }

    /**
     * Set types
     *
     * @param \Doctrine\Common\Collections\Collection $types
     * @return Fournisseurpiece
     */
    public function setTypes(\Doctrine\Common\Collections\Collection $types = null) {
        $this->types = $types;

        return $this;
    }

    /**
     * Remove fournisseurpiece
     *
     * @param \NNGenie\InfosMatBundle\Entity\Type $fournisseurpiece
     * @return Fournisseurpiece
     */
    public function removeType(\NNGenie\InfosMatBundle\Entity\Type $fournisseurpiece) {
        $this->fournisseurspieces->removeElement($fournisseurpiece);
        return $this;
    }
    
    /**
     * Set adresse
     *
     * @param \NNGenie\InfosMatBundle\Entity\Adresse $adresse
     * @return Fournisseurpiece
     */
    public function setAdresse(\NNGenie\InfosMatBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \NNGenie\InfosMatBundle\Entity\Adresse 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

}
