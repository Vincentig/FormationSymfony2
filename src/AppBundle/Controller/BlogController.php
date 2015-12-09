<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \AppBundle\Entity\Article;

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

        $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
        $articles = $articleManager->findAll();


//        $articles = [
//            ['id' => 1, 'titre' => 'Le titre', 'contenu' => 'Blablabla <b>bliblibli</b>'],
//            ['id' => 2, 'titre' => 'L\'autre titre', 'contenu' => 'le contenu de l\autre article'],
//            ['id' => 3, 'titre' => 'Le dernier titre', 'contenu' => 'le  dernier contenu du dernier article']
//        ];

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
        $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
        $article = $articleManager->find($id);

        $commentaireManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Commentaire');
        $commentaires = $commentaireManager->findBy(array('article' => $article));
        // replace this example code with whatever you need
        return $this->render('blog/article.html.twig', array(
                    'article' => $article,
                    'commentaires' => $commentaires
        ));
    }

    /**
     * @Route("/admin/ajouter",
     *      name="blog_ajouter")
     */
    public function ajouterAction() {

        $article = new Article();
        $article->setTitre('Le nouvel article créé depuis le controleur')->setContenu('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu sem sem. Suspendisse maximus pellentesque diam vitae vehicula. Ut rutrum nibh elit, sit amet interdum orci ultrices quis. Pellentesque vel congue turpis, eget rhoncus lacus. Nullam mollis lectus at tellus maximus commodo. Aenean nisl dui, bibendum quis enim in, vehicula consectetur dolor. Quisque iaculis ex dolor, ac condimentum dui rhoncus at. Ut condimentum felis lorem, et mattis orci euismod eget. Donec massa sapien, egestas a augue tincidunt, ultrices volutpat nisi. Ut iaculis luctus libero ac commodo. Nunc nisi augue, efficitur nec odio sed, molestie pulvinar massa. Aliquam vulputate gravida ligula eu aliquam. Vivamus a eros maximus, fermentum est ut, vestibulum diam. Nulla fermentum a est sit amet laoreet.

Mauris vitae augue vitae augue mollis vulputate ac ut neque. Donec at varius urna. Cras suscipit felis ipsum, sit amet auctor ipsum aliquet in. Aliquam a libero quis sapien blandit tristique ac nec mi. Pellentesque facilisis magna tortor, a sollicitudin ipsum pharetra ut. Duis bibendum tincidunt metus nec vehicula. Mauris finibus lectus vitae tortor egestas commodo. Curabitur condimentum elit quis lorem ornare, rutrum placerat elit laoreet. Praesent volutpat dui sed molestie viverra. Nunc mollis lacinia felis, quis ullamcorper elit dictum id. Pellentesque fringilla commodo nulla, consequat luctus lectus ullamcorper ac. Nullam lacinia purus sed nibh accumsan, quis aliquet ex bibendum.

Ut eu ex euismod, vehicula mi nec, porta arcu. Fusce cursus porta lacinia. Vestibulum sollicitudin, sapien eu efficitur dignissim, lorem purus rhoncus eros, vel tincidunt sem enim egestas ante. Nullam lacinia rutrum leo. Fusce pretium risus vel justo fringilla sodales a vel lorem. Vivamus dignissim, diam non maximus egestas, lectus magna commodo lectus, vel varius ligula orci eget justo. Morbi commodo turpis ut condimentum volutpat. Praesent vel tempor leo. Pellentesque sed dapibus lacus. Morbi vulputate tortor ut lorem vehicula molestie sit amet sit amet dolor. Duis feugiat convallis tortor eget auctor. ')
                ->setAuteur('Vincent');

        $image = new \AppBundle\Entity\Image();
        $image->setUrl('001.jpg');
        $image->setAlt('La premiere image');

        $article->setImage($image);

        $doctrine = $this->getDoctrine();
        $manageur = $doctrine->getManager(); //gère la base de donnée

        $commentaire1 = new \AppBundle\Entity\Commentaire();
        $commentaire1->setAuteur('vincent');
        $commentaire1->setContenu('Trop de la balle !');
        $commentaire1->setArticle($article);

        $commentaire2 = new \AppBundle\Entity\Commentaire();
        $commentaire2->setAuteur('TotoLeHero');
        $commentaire2->setContenu('génial ça marche');
        $commentaire2->setArticle($article);

        $manageur->persist($commentaire1);
        $manageur->persist($commentaire2);
        $manageur->persist($article);
        try {
            $manageur->flush();
        } catch (Exception $ex) {
            echo $ex;
        }

        $url = $this->generateUrl('blog_article', array('id' => $article->getId()));

        return $this->redirect($url);
    }

    /**
     * @Route("/admin/modifier/{id}",
     *      name="blog_modifier", 
     *      requirements={"id": "\d+"})
     */
    public function modifierAction($id) {
        // replace this example code with whatever you need
        return $this->render('blog/modifier.html.twig', array(
                    'id' => $id
        ));
    }

    /**
     * 
     */
    public function menuGaucheAction($nombre) {
        $articles = [
            ['id' => 1, 'titre' => 'Le titre', 'contenu' => 'Blablabla <b>bliblibli</b>'],
            ['id' => 2, 'titre' => 'L\'autre titre', 'contenu' => 'le contenu de l\autre article'],
            ['id' => 3, 'titre' => 'Le dernier titre', 'contenu' => 'le  dernier contenu du dernier article']
        ];

        return $this->render('blog/menu_gauche.html.twig', array(
                    'articles' => $articles
        ));
    }

}
