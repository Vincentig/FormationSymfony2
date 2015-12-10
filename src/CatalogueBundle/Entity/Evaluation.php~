<?php

namespace CatalogueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="cat_evaluation")
 * @ORM\Entity(repositoryClass="CatalogueBundle\Repository\EvaluationRepository")
 */
class Evaluation {

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
     * @ORM\Column(name="note", type="decimal", precision=3, scale=1)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="utilisateur", type="string", length=255,nullable=true)
     */
    private $utilisateur;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Evaluation
     */
    public function setNote($note) {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set utilisateur
     *
     * @param string $utilisateur
     *
     * @return Evaluation
     */
    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return string
     */
    public function getUtilisateur() {
        return $this->utilisateur;
    }

}
