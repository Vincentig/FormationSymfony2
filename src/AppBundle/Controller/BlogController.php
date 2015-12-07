<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * prefix blog
 * @Route("/blog")
 */
class BlogController extends Controller {

    /**
     * @Route("/{page}",
     *      name="blog_homepage", 
     *      defaults={"page":1}, 
     *      requirements={"page": "\d+"})
     */
    public function indexAction($page) {

        $articles = [
            ['titre' => 'Le titre', 'contenu' => 'Blablabla <b>bliblibli</b>'],
            ['titre' => 'L\'autre titre', 'contenu' => 'le contenu de l\autre article'],
            ['titre' => 'Le dernier titre', 'contenu' => 'le  dernier contenu du dernier article']
        ];

        return $this->render('blog/index.html.twig', array(
                    'articles' => $articles,
                    'page' => $page
        ));
    }

    /**
     * @Route("/article/{id}",
     *      name="blog_article", 
     *      requirements={"id": "\d+"})
     */
    public function articleAction($id) {
        // replace this example code with whatever you need
        return $this->render('blog/article.html.twig', array(
                    'id' => $id
        ));
    }

    /**
     * @Route("/admin/ajouter",
     *      name="blog_ajouter")
     */
    public function ajouterAction() {
        // replace this example code with whatever you need
        return $this->render('blog/ajouter.html.twig', array(
        ));
    }

    /**
     * @Route("/admin/modifier/{id}",
     *      name="blog_article", 
     *      requirements={"id": "\d+"})
     */
    public function modifierAction($id) {
        // replace this example code with whatever you need
        return $this->render('blog/modifier.html.twig', array(
                    'id' => $id
        ));
    }

}
