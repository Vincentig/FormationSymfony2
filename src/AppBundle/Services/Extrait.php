<?php

namespace AppBundle\Services;

/**
 * Description of Extrait
 *
 * @author hb
 */
class Extrait extends \Twig_Extension {

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

    /*
     * Retourne le nom de la classe
     */

    public function getName() {
        return 'Extrait';
    }

    /*
     * retourne un tableau avec le nom comment va s'appeler la fouction dans twig.
     */

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('extrait', array($this, 'extraire'))
        );
//        return array(
//            'extrait' => new \Twig_Function_Method($this, 'extraire')
//        );
    }

}
