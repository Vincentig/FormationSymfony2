<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article" )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Le titre doit contenir au moins {{ limit }} caractères",
     * )
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime(
     * message = "date pas bonne")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetime", nullable=true)
     * 
     */
    private $dateModification;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;

    /**
     *
     * @var \AppBundle\Entity\Image 
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     * 
     * @Assert\Valid
     *  
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Categorie", inversedBy="articles", cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commentaire", mappedBy="article", cascade={"persist","remove"})
     */
    private $commentaires;

    /*
     * 
     */
    private $extrait;

    const NBARTICLESPAGE = 6;
    const NBARTICLESPAGECATEGORIE = 8;

    function __construct() {
        $this->publication = true;
        $this->date = new \DateTime();
        $this->categories = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Article
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Article
     */
    public function setContenu($contenu) {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu() {
        return $this->contenu;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     *
     * @return Article
     */
    public function setAuteur($auteur) {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur() {
        return $this->auteur;
    }

    /**
     * Set publication
     *
     * @param boolean $publication
     *
     * @return Article
     */
    public function setPublication($publication) {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean
     */
    public function getPublication() {
        return $this->publication;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Article
     */
    public function setImage(\AppBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Categorie $category
     *
     * @return Article
     */
    public function addCategory(\AppBundle\Entity\Categorie $category) {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Categorie $category
     */
    public function removeCategory(\AppBundle\Entity\Categorie $category) {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Article
     */
    public function addCommentaire(\AppBundle\Entity\Commentaire $commentaire) {

        $commentaire->setArticle($this);
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\AppBundle\Entity\Commentaire $commentaire) {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires() {
        return $this->commentaires;
    }

    /**
     * Set titre
     *
     * @param string $extrait
     *
     * @return Article
     */
    public function setExtrait($extrait) {
        $this->extrait = $extrait;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getExtrait() {
        return $this->extrait;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return Article
     */
    public function setDateModification($dateModification) {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
    public function getDateModification() {
        return $this->dateModification;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate() {
        $this->setDateModification(new \DateTime());
    }

}
