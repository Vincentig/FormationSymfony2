<?php

namespace CatalogueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \CatalogueBundle\Entity\Categorie;
use \CatalogueBundle\Entity\Image;

/**
 * prefix catalogue
 * @Route("/catalogue/categorie")
 */
class CategorieController extends Controller {

    public function menuGaucheAction($nombre) {
        // $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
//        $articles = $articleManager->findAll();
        //    $articles = $articleManager->findBy(array(), array('date' => 'desc'), $nombre, 0);

        return $this->render('CatalogueBundle:catalogue:menu_gauche.html.twig', array(
        ));
    }

    /**
     * @Route("/admin/ajouter",
     *   name="catalogue_ajouter_catagorie")
     */
    public function ajouterCategorieAction() {
        $em = $this->getDoctrine()->getManager();

        $categorie = new Categorie();
        $categorie->setTitre('Film');
        $categorie->setDescription('Retrouvez une sélection unique de films récents ou anciens, toute catégories.');

        $image = new Image();
        $image->setAlt('Catégorie films');
        $image->setUrl('films.jpg');

        $categorie->setImage($image);

        $em->persist($categorie);

        try {
            $em->flush();
        } catch (Exception $ex) {
            echo $ex;
        }

        $url = $this->generateUrl('catalogue_catagorie', array('id' => $categorie->getId()));

        return $this->redirect($url);
    }

    /**
     * @Route("/{id}",
     *      name="catalogue_catagorie",
     *      requirements={"id": "\d+"}))
     */
    public function categorieAction($id) {
        $categorieManager = $this->getDoctrine()->getManager()->getRepository('CatalogueBundle:Categorie');
        // $categorie = $categorieManager->find($id);

        $categorie = $categorieManager->getFullCategorie($id);

        return $this->render('CatalogueBundle:catalogue:categorie.html.twig', array(
                    'categorie' => $categorie
        ));
    }

}
