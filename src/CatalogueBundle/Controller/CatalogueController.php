<?php

namespace CatalogueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \CatalogueBundle\Entity\Categorie;
use \CatalogueBundle\Entity\Image;

/**
 * prefix catalogue
 * @Route("/catalogue")
 */
class CatalogueController extends Controller {

    /**
     * @Route("/{page}",
     *      name="catalogue_homepage", 
     *      defaults={"page":1}, 
     *      requirements={"page": "\d+"})
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $categorieManager = $em->getRepository('CatalogueBundle:Categorie');
        $categories = $categorieManager->getAllCategoriesWithImage();
        return $this->render('CatalogueBundle:catalogue:index.html.twig', array(
                    'categories' => $categories
        ));
    }

    public function menuGaucheAction($nombre) {
        // $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
//        $articles = $articleManager->findAll();
        //    $articles = $articleManager->findBy(array(), array('date' => 'desc'), $nombre, 0);

        return $this->render('CatalogueBundle:catalogue:menu_gauche.html.twig', array(
        ));
    }

}
