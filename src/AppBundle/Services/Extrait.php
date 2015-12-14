<?php

namespace AppBundle\Services;

/**
 * Description of Extrait
 *
 * @author hb
 */
class Extrait {

    private $tailleTexte;
    private $suite;

    public function __construct($longueur, $suite) {
        $this->tailleTexte = $longueur;
        $this->suite = $suite;
    }

    public function extraire($text) {
        $textTemp = strip_tags($text);
        if (strlen($textTemp) > $this->tailleTexte) {
            $textTemp = substr($textTemp, 0, $this->tailleTexte);
            $positionDernierEspace = strripos($textTemp, ' ');
            $textTemp = substr($textTemp, 0, $positionDernierEspace) . ' ' . $this->suite;
//            $textTemp = 'Extrait ...';
        }
        return $textTemp;
    }

}
