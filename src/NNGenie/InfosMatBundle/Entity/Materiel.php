<?php

namespace NNGenie\InfosMatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel")
 * @ORM\Entity(repositoryClass="NNGenie\InfosMatBundle\Entity\Repository\MaterielRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Materiel
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
     * @ORM\OneToOne(targetEntity="Etat",cascade={"persist"})
     * @ORM\JoinColumn(name="etat", referencedColumnName="id")
     */
    private $etat;

    /**
     * @var \Fournisseur 
     * @ORM\OneToOne(targetEntity="Fournisseur",cascade={"persist"})
     * @ORM\JoinColumn(name="fournisseur", referencedColumnName="id")
     */
    private $fournisseur;
   
    /**
     * @var \Genre 
     * @ORM\OneToOne(targetEntity="Genre",cascade={"persist"})
     * @ORM\JoinColumn(name="genre", referencedColumnName="id")
     */
    private $genre;
    
    /**
     * @var \Localisation 
     * @ORM\OneToOne(targetEntity="Localisation",cascade={"persist"})
     * @ORM\JoinColumn(name="localisation", referencedColumnName="id")
     */
    private $localisation;
    
    /**
     * @var \Proprietaire 
     * @ORM\OneToOne(targetEntity="Proprietaire",cascade={"persist"})
     * @ORM\JoinColumn(name="proprietaire", referencedColumnName="id")
     */
    private $proprietaire;

    /**
     * @var \Type 
     * @ORM\OneToOne(targetEntity="Type",cascade={"persist"})
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     */
    private $type;
    
    /**
    * @ORM\OneToMany(targetEntity="Aime", mappedBy="materiel", cascade={"remove", "persist"})
    */
    private $aimes;
    
    /**
    * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="materiel", cascade={"remove", "persist"})
    */
    private $commentaires;
    
    /**
    * @ORM\OneToMany(targetEntity="Image", mappedBy="materiel", cascade={"remove", "persist"})
    */
    private $images;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true) 
    */
    private $mainpath;

    /**
     * @Assert\File(maxSize="6000000") 
    */
    private $file;
    
    private $temp;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer", nullable=true)
     */
    private $statut;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statut = 1;
        $this->aimes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nbvues =0;
        $this->datecreation = new \Datetime();
        $this->datemodification = new \Datetime();
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
     * @return Materiel
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
     * Set chassis
     *
     * @param string $chassis
     * @return Materiel
     */
    public function setChassis($chassis)
    {
        $this->chassis = $chassis;

        return $this;
    }

    /**
     * Get chassis
     *
     * @return string 
     */
    public function getChassis()
    {
        return $this->chassis;
    }

    /**
     * Set prix
     *
     * @param float $prix
     * @return Materiel
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Materiel
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Materiel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Materiel
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime 
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set datemodification
     *
     * @param \DateTime $datemodification
     * @return Materiel
     */
    public function setDatemodification($datemodification)
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    /**
     * Get datemodification
     *
     * @return \DateTime 
     */
    public function getDatemodification()
    {
        return $this->datemodification;
    }

    /**
     * Set nbvues
     *
     * @param integer $nbvues
     * @return Materiel
     */
    public function setNbvues($nbvues)
    {
        $this->nbvues = $nbvues;

        return $this;
    }

    /**
     * Get nbvues
     *
     * @return integer 
     */
    public function getNbvues()
    {
        return $this->nbvues;
    }

    /**
     * Set etat
     *
     * @param \NNGenie\InfosMatBundle\Entity\Etat $etat
     * @return Materiel
     */
    public function setEtat(\NNGenie\InfosMatBundle\Entity\Etat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \NNGenie\InfosMatBundle\Entity\Etat 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set fournisseur
     *
     * @param \NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur
     * @return Materiel
     */
    public function setFournisseur(\NNGenie\InfosMatBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \NNGenie\InfosMatBundle\Entity\Fournisseur 
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set genre
     *
     * @param \NNGenie\InfosMatBundle\Entity\Genre $genre
     * @return Materiel
     */
    public function setGenre(\NNGenie\InfosMatBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \NNGenie\InfosMatBundle\Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set localisation
     *
     * @param \NNGenie\InfosMatBundle\Entity\Localisation $localisation
     * @return Materiel
     */
    public function setLocalisation(\NNGenie\InfosMatBundle\Entity\Localisation $localisation = null)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return \NNGenie\InfosMatBundle\Entity\Localisation 
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set proprietaire
     *
     * @param \NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire
     * @return Materiel
     */
    public function setProprietaire(\NNGenie\InfosMatBundle\Entity\Proprietaire $proprietaire = null)
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * Get proprietaire
     *
     * @return \NNGenie\InfosMatBundle\Entity\Proprietaire 
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * Set type
     *
     * @param \NNGenie\InfosMatBundle\Entity\Type $type
     * @return Materiel
     */
    public function setType(\NNGenie\InfosMatBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \NNGenie\InfosMatBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Add aime
     *
     * @param \NNGenie\InfosMatBundle\Entity\Aime $aime 
     * @return User
     */
    public function addAime(\NNGenie\InfosMatBundle\Entity\Aime $aime)
    {
        $this->aimes[] = $aime;
        return $this;
    }
    
    /**
     * Get aimes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAimes()
    {
        return $this->aimes;
    }
    
    /**
     * Set aimes
     *
     * @param \Doctrine\Common\Collections\Collection $aimes
     * @return \User
     */
    public function setAimes(\Doctrine\Common\Collections\Collection $aimes = null)
    {
        $this->aimes = $aimes;

        return $this;
    }
    
    /**
     * Remove aime
     *
     * @param \NNGenie\InfosMatBundle\Entity\Aime $aime
     */
    public function removeAime(\NNGenie\InfosMatBundle\Entity\Aime $aime)
    {
        $this->aimes->removeElement($aime);
    }
    
    /**
     * Add commentaire
     *
     * @param \NNGenie\InfosMatBundle\Entity\Commentaire $commentaire 
     * @return User
     */
    public function addCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;
        return $this;
    }
    
    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
    
    /**
     * Set commentaires
     *
     * @param \Doctrine\Common\Collections\Collection $commentaires
     * @return \User
     */
    public function setCommentaires(\Doctrine\Common\Collections\Collection $commentaires = null)
    {
        $this->commentaires = $commentaires;

        return $this;
    }
    
    /**
     * Remove commentaire
     *
     * @param \NNGenie\InfosMatBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\NNGenie\InfosMatBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }
    
    /**
     * Add image
     *
     * @param \NNGenie\InfosMatBundle\Entity\Image $image 
     * @return User
     */
    public function addImage(\NNGenie\InfosMatBundle\Entity\Image $image)
    {
        $this->images[] = $image;
        return $this;
    }
    
    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
    
    /**
     * Set images
     *
     * @param \Doctrine\Common\Collections\Collection $images
     * @return \User
     */
    public function setImages(\Doctrine\Common\Collections\Collection $images = null)
    {
        $this->images = $images;

        return $this;
    }
    
    /**
     * Remove image
     *
     * @param \NNGenie\InfosMatBundle\Entity\Image $image
     */
    public function removeImage(\NNGenie\InfosMatBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }
    
    /**
     * Set mainpath
     *
     * @param string $mainpath
     * @return Utilisateur
     */
    public function setMainpath($mainpath) {
        $this->mainpath = $mainpath;

        return $this;
    }

    /**
     * Get mainpath
     *
     * @return string 
     */
    public function getMainpath() {
        return $this->mainpath;
    }

    /**
     * @param UploadedFile $file
     * @return object
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        // check if we have an old image mainpath
        if (isset($this->mainpath)) {
            // store the old name to delete after the update
            $this->temp = $this->mainpath;
            $this->mainpath = null;
        } else {
            $this->mainpath = 'initial';
        }
    }

    /**
     * Get the file used for profile picture uploads
     * 
     * @return UploadedFile
     */
    public function getFile() {

        return $this->file;
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../web/uploads/mainMateriels';
    }

    /**
     * @ORM\PrePersist() 
     * @ORM\PreUpdate() 
     */
    public function preUpload() {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->mainpath = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * Generates a 32 char long random filename
     * 
     * @return string
     */
    public function generateRandomProfilePictureFilename() {
        $count = 0;
        do {
            $generator = new SecureRandom();
            $random = $generator->nextBytes(16);
            $randomString = bin2hex($random);
            $count++;
        } while (file_exists($this->getUploadRootDir() . '/' . $randomString . '.' . $this->getFile()->guessExtension()) && $count < 50);

        return $randomString;
    }

    /**
     * @ORM\PostPersist() 
     * @ORM\PostUpdate() 
     */
    public function upload() {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->mainpath);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            //unlink($this->getUploadRootDir().'/'.$this->temp);
            //ou je renomme
            rename($this->getUploadRootDir() . '/' . $this->temp, $this->getUploadRootDir() . '/old' . $this->temp);
            // clear the temp image mainpath
            $this->temp = null;
        }
        $this->file = null;
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
}
