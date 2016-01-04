<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder {

    private $factory;
    private $trad;
    private $doctrine;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, $doctrine, $trad) {
        $this->factory = $factory;
        $this->trad = $trad;
        $this->doctrine = $doctrine;
    }

//    public function createMainMenu(FactoryInterface $factory, array $options) {
//        $menu = $factory->createItem('root');
//        $menu->setChildrenAttribute('class', 'nav');
//
//        $menu->addChild('Projects', array('route' => 'acme_hello_projects'))
//                ->setAttribute('icon', 'icon-list');
//
//        $menu->addChild('Employees', array('route' => 'acme_hello_employees'))
//                ->setAttribute('icon', 'icon-group');
//        return $menu;
//    }

    public function createMainMenu(array $options) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');

        $index = $this->trad->trans('menu.index');
        $menu->addChild($index, array('route' => 'blog_homepage'))
                ->setAttribute('icon', 'glyphicon glyphicon-list');

        $admin = $this->trad->trans('menu.admin');
        $menu->addChild($admin, array('route' => 'admin_homepage'))
                ->setAttribute('icon', 'glyphicon glyphicon-list');

        $sousMenu = $this->trad->trans('menu.sous_menu');
        $menu[$admin]->addChild($sousMenu);


        $articleManager = $this->doctrine->getManager()->getRepository('AppBundle:Article');

        $articles = $articleManager->findBy(array(), array('date' => 'desc'), 3, 0);



        foreach ($articles as $article) {
            $menu->addChild($article->getId(), array('label' => $article->getTitre(), 'route' => 'blog_article',
                'routeParameters' => array('id' => $article->getId())))
            ;
        }

        // ... add more children

        return $menu;
    }

}
