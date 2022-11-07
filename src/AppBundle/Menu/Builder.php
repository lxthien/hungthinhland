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

    public function mainMenuRight(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array (
                'class' => 'nav navbar-nav navbar-right',
            ),
        ));

        $menu->addChild('Sửa chữa nhà', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'sua-chua-nha']
        ]);

        
        $menu->addChild('Kinh nghiệm', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Kinh nghiệm']->addChild('Cẩm nang xây dựng', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung', 'level2' => 'cam-nang-xay-dung']
        ]);

        $menu['Kinh nghiệm']->addChild('Phong thủy xây dựng', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung', 'level2' => 'phong-thuy-xay-dung']
        ]);

        $menu['Kinh nghiệm']->addChild('Luật xây dựng', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung', 'level2' => 'luat-xay-dung']
        ]);

        $menu->addChild('Dự án thi công', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');
        
        $menu['Dự án thi công']->addChild('Dự án xây dựng nhà', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong', 'level2' => 'du-an-xay-dung-nha']
        ]);
        
        $menu['Dự án thi công']->addChild('Dự án sửa chữa nhà', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong', 'level2' => 'du-an-sua-chua-nha']
        ]);

        $menu['Dự án thi công']->addChild('Dự án quán cà phê', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong', 'level2' => 'du-an-quan-ca-phe']
        ]);

        // Contact us
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

    public function ampMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array (
                'class' => 'nav navbar-nav',
            ),
        ));

        $menu->addChild('Giới thiệu', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'gioi-thieu-ve-nam-viet-phat']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Giới thiệu']->addChild('Sơ đồ tổ chức', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'so-do-to-chuc']
        ]);
        
        $menu['Giới thiệu']->addChild('Về chúng tôi', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'gioi-thieu-ve-nam-viet-phat']
        ]);

        $menu['Giới thiệu']->addChild('Tuyển dụng', [
            'route' => 'news_show',
            'routeParameters' => ['slug' => 'tuyen-dung']
        ]);

        $menu->addChild('Bảng giá', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'bang-gia-xay-dung']
        ]);

        $menu->addChild('Thiết kế nhà', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'thiet-ke-nha']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Thiết kế nhà']->addChild('Thiết kế nhà phố', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'thiet-ke-nha', 'level2' => 'thiet-ke-nha-pho']
        ]);
        
        $menu['Thiết kế nhà']->addChild('Thiết kế biệt thự', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'thiet-ke-nha', 'level2' => 'thiet-ke-biet-thu']
        ]);

        $menu->addChild('Xây dựng nhà', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'xay-dung']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Xây dựng nhà']->addChild('Xây nhà trọn gói', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'xay-dung', 'level2' => 'xay-nha-tron-goi']
        ]);

        $menu['Xây dựng nhà']->addChild('Xây dựng phần thô', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'xay-dung', 'level2' => 'xay-dung-phan-tho']
        ]);

        $menu['Xây dựng nhà']->addChild('Xây nhà biệt thự', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'xay-dung', 'level2' => 'xay-nha-biet-thu']
        ]);

        $menu['Xây dựng nhà']->addChild('Xây nhà cấp 4', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'xay-dung', 'level2' => 'xay-nha-cap-4']
        ]);

        $menu['Xây dựng nhà']->addChild('Xây dựng nhà xưởng', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'xay-dung', 'level2' => 'xay-dung-nha-xuong']
        ]);

        $menu->addChild('Sửa chữa nhà', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'sua-chua-nha']
        ]);

        
        $menu->addChild('Kinh nghiệm', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');

        $menu['Kinh nghiệm']->addChild('Cẩm nang xây dựng', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung', 'level2' => 'cam-nang-xay-dung']
        ]);

        $menu['Kinh nghiệm']->addChild('Phong thủy xây dựng', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung', 'level2' => 'phong-thuy-xay-dung']
        ]);

        $menu['Kinh nghiệm']->addChild('Luật xây dựng', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'kinh-nghiem-xay-dung', 'level2' => 'luat-xay-dung']
        ]);

        $menu->addChild('Dự án thi công', [
            'route' => 'news_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong']
        ])
        ->setAttribute('class', 'dropdown')
        ->setLinkAttribute('class', 'dropdown-toggle')
        ->setLinkAttribute('data-toggle', 'dropdown')
        ->setChildrenAttribute('class', 'dropdown-menu');
        
        $menu['Dự án thi công']->addChild('Dự án xây dựng nhà', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong', 'level2' => 'du-an-xay-dung-nha']
        ]);
        
        $menu['Dự án thi công']->addChild('Dự án sửa chữa nhà', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong', 'level2' => 'du-an-sua-chua-nha']
        ]);

        $menu['Dự án thi công']->addChild('Dự án quán cà phê', [
            'route' => 'list_category',
            'routeParameters' => ['level1' => 'du-an-thi-cong', 'level2' => 'du-an-quan-ca-phe']
        ]);

        // Contact us
        $menu->addChild('Liên hệ', [
            'route' => 'contact'
        ]);

        return $menu;
    }
}