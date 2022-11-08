<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array (
                'class' => 'nav navbar-nav',
            ),
        ));

        $menu->addChild('Giới thiệu', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'gioi-thieu']
        ]);

        $menu->addChild('Dự án', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'du-an']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');
        
        $menu['Dự án']->addChild('Dự án đang triển khai', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an', 'level2' => 'du-an-dang-trien-khai']
        ]);
        
        $menu['Dự án']->addChild('Dự án đã triển khai', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an', 'level2' => 'du-an-da-trien-khai']
        ]);

        $menu->addChild('Tin tức', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'tin-tuc']
        ]);

        $menu->addChild('Liên hệ', [
            'route' => 'contact'
        ]);

        return $menu;
    }

    public function footerMenu(FactoryInterface $factory, array $options)
    {
        $footerMenu = $factory->createItem('root');

        return $footerMenu;
    }
}