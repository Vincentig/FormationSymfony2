<?php

namespace CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Produit
 *
 * @ORM\Table(name="cat_produit")
 * @ORM\Entity(repositoryClass="CatalogueBundle\Repository\ProduitRepository")
 */
class Produit {

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
     * @ORM\Column(name="prix", type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var bool
     *
     * @ORM\Column(name="vente", type="boolean")
     */
    private $vente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *
     * @var CatalogueBundle\Entity\Image
     * @ORM\OneToOne(targetEntity="CatalogueBundle\Entity\Image" , cascade={"persist","remove"})
     */
    private $image;

    /**
     *
     * @var CatalogueBundle\Entity\Evaluation
     * @ORM\OneToOne(targetEntity="CatalogueBundle\Entity\Evaluation" , cascade={"persist"})
     */
    private $evaluation;

    /**
     * @ORM\ManyToMany(targetEntity="CatalogueBundle\Entity\Categorie" , inversedBy="produits", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    function __construct() {
        $this->date = new \DateTime();
        $this->categories = new ArrayCollection();
        $this->vente = true;
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
     * Set prix
     *
     * @param string $prix
     *
     * @return Produit
     */
    public function setPrix($prix) {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix() {
        return $this->prix;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Produit
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Produit
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set vente
     *
     * @param boolean $vente
     *
     * @return Produit
     */
    public function setVente($vente) {
        $this->vente = $vente;

        return $this;
    }

    /**
     * Get vente
     *
     * @return bool
     */
    public function getVente() {
        return $this->vente;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Produit
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
     * Set image
     *
     * @param \CatalogueBundle\Entity\Image $image
     *
     * @return Produit
     */
    public function setImage(\CatalogueBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \CatalogueBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set evaluation
     *
     * @param \CatalogueBundle\Entity\Evaluation $evaluation
     *
     * @return Produit
     */
    public function setEvaluation(\CatalogueBundle\Entity\Evaluation $evaluation = null) {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get evaluation
     *
     * @return \CatalogueBundle\Entity\Evaluation
     */
    public function getEvaluation() {
        return $this->evaluation;
    }

    /**
     * Add category
     *
     * @param \CatalogueBundle\Entity\Categorie $category
     *
     * @return Produit
     */
    public function addCategory(\CatalogueBundle\Entity\Categorie $category) {

        $category->addProduit($this);
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \CatalogueBundle\Entity\Categorie $category
     */
    public function removeCategory(\CatalogueBundle\Entity\Categorie $category) {

        $category->removeProduit($this);
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \CatalogueBundle\Entity\Categorie[]
     */
    public function getCategories() {
        return $this->categories;
    }

}
