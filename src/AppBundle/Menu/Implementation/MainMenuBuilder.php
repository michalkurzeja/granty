<?php

namespace AppBundle\Menu\Implementation;

use AppBundle\Menu\MenuBuilder;
use Knp\Menu\ItemInterface;

class MainMenuBuilder extends MenuBuilder
{
    /**
     * @param array $options
     * @return ItemInterface
     */
    public function build(array $options)
    {
        if (!$this->isUserLogged()) {
            return $this->getMenuForAnonymousUser();
        }

        $menu = $this->createRootItem();

        $menu->addChild('main.home', ['route' => 'homepage']);

        return $menu;
    }

    private function getMenuForAnonymousUser()
    {
        return $this->createRootItem();
    }
}