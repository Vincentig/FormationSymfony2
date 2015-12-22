<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \AppBundle\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use JMS\SecurityExtraBundle\Annotation\Secure;

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
     * @Secure(roles="ROLE_ADMIN, ROLE_USER")
     */
    public function indexAction($page) {

        $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
//        $articles = $articleManager->findAll();
        // $articles = $articleManager->findBy(array('publication' => true), array('date' => 'desc'), null, null);

        $nbParPage = \AppBundle\Entity\Article::NBARTICLESPAGE;

        $articles = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Article')
                ->getArticles($nbParPage, $page);
        $extrait = $this->get('app_extrait');
        foreach ($articles as $key => $article) {
            $article->setExtrait($extrait->extraire($article->getContenu()));
        }

        $nbPages = ceil(count($articles) / $nbParPage);

        // $articles = $articleManager->getArticles();
//        $articles = [
//            ['id' => 1, 'titre' => 'Le titre', 'contenu' => 'Blablabla <b>bliblibli</b>'],
//            ['id' => 2, 'titre' => 'L\'autre titre', 'contenu' => 'le contenu de l\autre article'],
//            ['id' => 3, 'titre' => 'Le dernier titre', 'contenu' => 'le  dernier contenu du dernier article']
//        ];

        return $this->render('blog/index.html.twig', array(
                    'articles' => $articles,
                    'page' => $page,
                    'nbPage' => $nbPages
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

        $commentaire = new \AppBundle\Entity\Commentaire();
        $form = $this->createForm(new \AppBundle\Form\CommentaireType(), $commentaire);



        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $commentaire->setArticle($article);

//                $security = $this->get('security.context');
//                $token = $security->getToken();
//                $user = $token->getUser();

                $user = $this->getUser();
//                var_dump($user);
//                die;
                $commentaire->setAuteur($user);

                $em = $this->getDoctrine()->getManager();
                $em->persist($commentaire);
                $session = $this->get('session');
                try {
                    $em->flush();
                    $session->getFlashBag()->add(
                            'info', 'Commentaire enregistré'
                    );
                    $url = $this->generateUrl('blog_article', array('id' => $article->getId()));
                    return $this->redirect($url);
                } catch (Exception $ex) {
                    echo 'erreur enregistrement article';
                }
            }
        }

//        $commentaireManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Commentaire');
//        $commentaires = $commentaireManager->findBy(
//                array('article' => $article), array('date' => 'desc'));
        // replace this example code with whatever you need
        return $this->render('blog/article.html.twig', array(
                    'article' => $article,
                    'form' => $form->createView()
//                    'commentaires' => $commentaires
        ));
    }

    /**
     * @Route("/admin/ajouter",
     *      name="blog_ajouter")
     */
    public function ajouterAction() {
        /*
          $article = new Article();
          $article->setTitre('Le nouvel article créé depuis le controleur')->setContenu('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu sem sem. Suspendisse maximus pellentesque diam vitae vehicula. Ut rutrum nibh elit, sit amet interdum orci ultrices quis. Pellentesque vel congue turpis, eget rhoncus lacus. Nullam mollis lectus at tellus maximus commodo. Aenean nisl dui, bibendum quis enim in, vehicula consectetur dolor. Quisque iaculis ex dolor, ac condimentum dui rhoncus at. Ut condimentum felis lorem, et mattis orci euismod eget. Donec massa sapien, egestas a augue tincidunt, ultrices volutpat nisi. Ut iaculis luctus libero ac commodo. Nunc nisi augue, efficitur nec odio sed, molestie pulvinar massa. Aliquam vulputate gravida ligula eu aliquam. Vivamus a eros maximus, fermentum est ut, vestibulum diam. Nulla fermentum a est sit amet laoreet.<br/>
          <br/>
          Mauris vitae augue vitae augue mollis vulputate ac ut neque. Donec at varius urna. Cras suscipit felis ipsum, sit amet auctor ipsum aliquet in. Aliquam a libero quis sapien blandit tristique ac nec mi. Pellentesque facilisis magna tortor, a sollicitudin ipsum pharetra ut. Duis bibendum tincidunt metus nec vehicula. Mauris finibus lectus vitae tortor egestas commodo. Curabitur condimentum elit quis lorem ornare, rutrum placerat elit laoreet. Praesent volutpat dui sed molestie viverra. Nunc mollis lacinia felis, quis ullamcorper elit dictum id. Pellentesque fringilla commodo nulla, consequat luctus lectus ullamcorper ac. Nullam lacinia purus sed nibh accumsan, quis aliquet ex bibendum.<br/>
          <br/>
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

          $commentaire3 = new \AppBundle\Entity\Commentaire();
          $commentaire3->setAuteur('Jean Aymard');
          $commentaire3->setContenu('Quand y en a marre y a malabard');
          $article->addCommentaire($commentaire3);

          // en commentaire car unique en base et déjà créés
          $categorie1 = $this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->find(1);
          //      $categorie1 = new \AppBundle\Entity\Categorie();
          //       $categorie1->setTitre('Chimie');
          $article->addCategory($categorie1);
          $categorie2 = $this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->find(2);
          //  $categorie2 = new \AppBundle\Entity\Categorie();
          //      $categorie2->setTitre('Blabla');
          $article->addCategory($categorie2);
          $categorie3 = $this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->find(5);
          $article->addCategory($categorie3);


          $manageur->persist($commentaire1);
          $manageur->persist($commentaire2);
          $manageur->persist($article);
          try {
          $manageur->flush();
          } catch (Exception $ex) {
          echo $ex;
          }
         */

        $article = new Article();
        /*       $formB = $this->createFormBuilder($article);
          //ancienne methode
          /*     $formB->add('titre')
          ->add('contenu', 'textarea')
          ->add('auteur', 'text')
          ->add('publication', 'checkbox')
          ->add('date', 'date')
          ->add('ok', 'submit');
         */
        //nouvelle methode
        /*      $formB->add('titre', TextType::class)
          ->add('contenu', TextareaType::class)
          ->add('auteur', TextType::class)
          ->add('publication', CheckboxType::class)
          ->add('date', DateType::class)
          ->add('ok', SubmitType::class);

          $form = $formB->getForm();
         */




// add flash messages



        $form = $this->createForm(new \AppBundle\Form\ArticleType(), $article);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $article->getImage()->upload();
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $session = $this->get('session');
                try {
                    $em->flush();
                    $session->getFlashBag()->add(
                            'info', 'Article enregistré'
                    );
                    $url = $this->generateUrl('blog_article', array('id' => $article->getId()));
                    return $this->redirect($url);
                } catch (Exception $ex) {
                    echo 'erreur enregistrement article';
                }
            }
        }

        return $this->render('blog/ajouter.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/modifier/{id}",
     *      name="blog_modifier", 
     *      requirements={"id": "\d+"})
     */
    public function modifierAction($id) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->find($id);
        $image = $article->getImage();

        $form = $this->createForm(new \AppBundle\Form\ArticleType(), $article);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {


                if ($image->getFile() !== null) {
                    $image->removeOldFile();
                    $image->upload();
                }
                $em = $this->getDoctrine()->getManager();
                $session = $this->get('session');
                try {
                    $em->flush();
                    $session->getFlashBag()->add(
                            'info', 'Article modifié'
                    );
                    $url = $this->generateUrl('blog_article', array('id' => $article->getId()));
                    return $this->redirect($url);
                } catch (Exception $ex) {
                    echo 'erreur enregistrement article';
                }
            }
        }

        return $this->render('blog/ajouter.html.twig', array(
                    'form' => $form->createView(),
                    'image' => $image
        ));
    }

    /**
     * @Route("/admin/supprimer/{id}",
     *      name="blog_supprimer", 
     *      requirements={"id": "\d+"})
     */
    public function supprimerAction($id) {


        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);
        $em->remove($article);

        $article->getImage()->removeOldFile();

        try {
            $em->flush();
        } catch (Exception $ex) {
            echo $ex;
        }

        /* return $this->render('blog/modifier.html.twig', array(
          'article' => $article
          )); */
        $url = $this->generateUrl('blog_homepage');

        return $this->redirect($url);
//        return $this->render('blog/supprimer.html.twig', array(
//                    'id' => $id
//        ));
    }

    /**
     * 
     */
    public function menuGaucheAction($nombre) {
//        $articles = [
//            ['id' => 1, 'titre' => 'Le titre', 'contenu' => 'Blablabla <b>bliblibli</b>'],
//            ['id' => 2, 'titre' => 'L\'autre titre', 'contenu' => 'le contenu de l\autre article'],
//            ['id' => 3, 'titre' => 'Le dernier titre', 'contenu' => 'le  dernier contenu du dernier article']
//        ];

        $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
//        $articles = $articleManager->findAll();
        $articles = $articleManager->findBy(array(), array('date' => 'desc'), $nombre, 0);

        return $this->render('blog/menu_gauche.html.twig', array(
                    'articles' => $articles
        ));
    }

    /**
     * @Route("/categorie/{titre}/{page}",
     *      name="blog_categorie", 
     *      requirements={"titre": "\w+", "page": "\d+"},
     *      defaults={"page":1})
     */
    public function categorieAction($titre, $page) {
//        $categorieManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie');
//        $categorie = $categorieManager->findOneBy(array('titre' => $titre));
//
//        $nbParPage = \AppBundle\Entity\Article::NBARTICLESPAGECATEGORIE;
//        var_dump(count($categorie->getArticles()));
//        $nbPages = ceil(count($categorie->getArticles()) / $nbParPage);

        $categorie = $this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->findOneBy(array('titre' => $titre));

        $nbParPage = \AppBundle\Entity\Article::NBARTICLESPAGECATEGORIE;

        $articleManager = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article');
        $articles = $articleManager->getArticlesByCategorie($nbParPage, $page, $titre);
        $nbPages = ceil(count($articles) / $nbParPage);


        return $this->render('blog/categorie.html.twig', array(
                    'articles' => $articles,
                    'categorie' => $categorie,
                    'page' => $page,
                    'nbPage' => $nbPages
        ));
    }

}
