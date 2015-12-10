<?php

namespace CatalogueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \CatalogueBundle\Entity\Produit;
use \CatalogueBundle\Entity\Image;

/**
 * 
 * @Route("/catalogue/produit")
 */
class ProduitController extends Controller {

    public function menuGaucheAction($nombre) {
        // $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
//        $articles = $articleManager->findAll();
        //    $articles = $articleManager->findBy(array(), array('date' => 'desc'), $nombre, 0);

        return $this->render('CatalogueBundle:catalogue:menu_gauche.html.twig', array(
        ));
    }

    /**
     * @Route("/admin/ajouter",
     *   name="catalogue_ajouter_produit")
     */
    public function ajouterProduitAction() {
        $em = $this->getDoctrine()->getManager();


        $produit = new Produit();

        $produit->setNom('The Matrix');
        $produit->setDescription("Programmeur anonyme dans un service administratif le jour, Thomas Anderson devient Neo la nuit venue. Sous ce pseudonyme, il est l'un des pirates les plus recherchés du cyber-espace. A cheval entre deux mondes, Neo est assailli par d'étranges songes et des messages cryptés provenant d'un certain Morpheus. Celui-ci l'exhorte à aller au-delà des apparences et à trouver la réponse à la question qui hante constamment ses pensées : qu'est-ce que la Matrice ? Nul ne le sait, et aucun homme n'est encore parvenu à en percer les defenses. Mais Morpheus est persuadé que Neo est l'Elu, le libérateur mythique de l'humanité annoncé selon la prophétie. Ensemble, ils se lancent dans une lutte sans retour contre la Matrice et ses terribles agents...");

        $produit->setPrix(15);
//        $categorie = new Categorie();
//        $categorie->setTitre('Film');
//        $categorie->setDescription('Retrouvez une sélection unique de films récents ou anciens, toute catégories.');

        $evaluation = new \CatalogueBundle\Entity\Evaluation();
        $evaluation->setNote(4);
        $produit->setEvaluation($evaluation);

        $categorieManager = $em->getRepository('CatalogueBundle:Categorie');
        $categorie = $categorieManager->find(1);
        $produit->addCategory($categorie);

        $image = new Image();
        $image->setAlt('matrix');
        $image->setUrl('matrix.jpg');

        $produit->setImage($image);

        $em->persist($produit);

        try {
            $em->flush();
        } catch (Exception $ex) {
            echo $ex;
        }

        $url = $this->generateUrl('catalogue_produit', array('id' => $produit->getId()));

        return $this->redirect($url);
    }

    /**
     * @Route("/{id}",
     *      name="catalogue_produit",
     *      requirements={"id": "\d+"}))
     */
    public function produitAction($id) {
        $produitManager = $this->getDoctrine()->getManager()->getRepository('CatalogueBundle:Produit');
        // $produit = $produitManager->find($id);
        $produit = $produitManager->getFullProduit($id);
        return $this->render('CatalogueBundle:catalogue:produit.html.twig', array(
                    'produit' => $produit
        ));
    }

}
