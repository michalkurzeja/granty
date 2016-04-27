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

        $menu = $this->createRootMenuItem();

        $menu->addChild('main.home', ['route' => 'homepage']);
        $menu->addChild('main.applications', ['route' => 'application_index']);

        return $menu;
    }

    private function getMenuForAnonymousUser()
    {
        return $this->createRootMenuItem();
    }
}