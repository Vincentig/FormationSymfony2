<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder {

    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory) {
        $this->factory = $factory;
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
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Index', array('route' => 'blog_homepage'))
                ->setAttribute('icon', 'glyphicon glyphicon-list');

        $menu->addChild('Admin', array('route' => 'admin_homepage'))
                ->setAttribute('icon', 'glyphicon glyphicon-list');


        // ... add more children

        return $menu;
    }

}
