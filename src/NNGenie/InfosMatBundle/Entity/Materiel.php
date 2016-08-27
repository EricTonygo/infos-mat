<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel", indexes={@ORM\Index(name="fk_materiel_etat1_idx", columns={"etat"}), @ORM\Index(name="fk_materiel_fournisseur1_idx", columns={"fournisseur"}), @ORM\Index(name="fk_materiel_localisation1_idx", columns={"localisation"}), @ORM\Index(name="fk_materiel_proprietaire1_idx", columns={"proprietaire"}), @ORM\Index(name="fk_materiel_type1_idx", columns={"type"}), @ORM\Index(name="fk_materiel_genre1_idx", columns={"genre"})})
 * @ORM\Entity
 */
class Materiel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="chassis", type="string", length=255, nullable=true)
     */
    private $chassis;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=true)
     */
    private $datecreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetime", nullable=true)
     */
    private $datemodification;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbvues", type="bigint", nullable=true)
     */
    private $nbvues;

    /**
     * @var \Etat
     *
     * @ORM\ManyToOne(targetEntity="Etat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat", referencedColumnName="id")
     * })
     */
    private $etat;

    /**
     * @var \Fournisseur
     *
     * @ORM\ManyToOne(targetEntity="Fournisseur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fournisseur", referencedColumnName="id")
     * })
     */
    private $fournisseur;

    /**
     * @var \Genre
     *
     * @ORM\ManyToOne(targetEntity="Genre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="genre", referencedColumnName="id")
     * })
     */
    private $genre;

    /**
     * @var \Localisation
     *
     * @ORM\ManyToOne(targetEntity="Localisation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="localisation", referencedColumnName="id")
     * })
     */
    private $localisation;

    /**
     * @var \Proprietaire
     *
     * @ORM\ManyToOne(targetEntity="Proprietaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proprietaire", referencedColumnName="id")
     * })
     */
    private $proprietaire;

    /**
     * @var \Type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;


}