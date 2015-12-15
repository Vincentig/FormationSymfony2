<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image {

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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     *
     * @Assert\Image(
     * mimeTypesMessage = "Ceci n'est pas une image")
     */
    private $file;

    /**
     * Get file
     *
     * @return 
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set file
     *
     * @return
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null) {
        $this->file = $file;
        return $this;
    }

    public function upload() {
        if (null === $this->file) {
            return;
        }
        $name = $this->file->getClientOriginalName();
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $name = md5(uniqid()) . '.' . $ext;

        $this->file->move($this->getUploadRootDir(), $name);
        $this->url = $name;
    }

    public function getUploadDir() {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'images';
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function removeOldFile() {

        if (is_file($this->getUploadRootDir() . '/' . $this->url))
            unlink($this->getUploadRootDir() . '/' . $this->url);
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
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt) {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt() {
        return $this->alt;
    }

}
