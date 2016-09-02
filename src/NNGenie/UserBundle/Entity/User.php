<?php

namespace NNGenie\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true) 
     */
    private $path;

    /**
     * @Assert\File(maxSize="6000000") 
    */
    private $file;
    
    private $temp;
    
    /**
    * @ORM\OneToMany(targetEntity="NNGenie\InfosMatBundle\Entity\Aime", mappedBy="user", cascade={"remove", "persist"})
    */
    private $aimes;
    
    /**
    * @ORM\OneToMany(targetEntity="NNGenie\InfosMatBundle\Entity\Commentaire", mappedBy="user", cascade={"remove", "persist"})
    */
    private $commentaires;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->aimes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return User
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
     * Add commentaire
     *
     * @param \NNGenie\InfosMatBundle\Entity\Aime $commentaire 
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
     * Set path
     *
     * @param string $path
     * @return Utilisateur
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param UploadedFile $file
     * @return object
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
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
        return __DIR__ . '/../../../web/uploads/profils';
    }

    /**
     * @ORM\PrePersist() 
     * @ORM\PreUpdate() 
     */
    public function preUpload() {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->getFile()->guessExtension();
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
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            //unlink($this->getUploadRootDir().'/'.$this->temp);
            //ou je renomme
            rename($this->getUploadRootDir() . '/' . $this->temp, $this->getUploadRootDir() . '/old' . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }
}
