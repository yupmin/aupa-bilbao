<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

/**
 * Class Builder
 * @package AppBundle\Menu
 */
class Builder
{
    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', [
            'navbar' => true,
        ]);

        $menu->addChild('Home', [
            'icon' => 'home',
            'route' => 'homepage',
        ]);

        $dropdown = $menu->addChild('Subpages', [
            'dropdown' => true,
            'caret' => true,
        ]);

        $dropdown->addChild('Subpage 1', ['route' => 'homepage']);
        $dropdown->addChild('Subpage 2', ['route' => 'homepage']);
        $dropdown->addChild('Subpage 3', ['route' => 'homepage']);

        return $menu;
    }
}
