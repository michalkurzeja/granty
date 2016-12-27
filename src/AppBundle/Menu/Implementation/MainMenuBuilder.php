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
    public function build(array $options): ItemInterface
    {
        if (!$this->isUserLogged()) {
            return $this->getMenuForAnonymousUser();
        }

        $isSuperAdmin = $this->getCurrentUser()->isSuperAdmin();

        $menu = $this->createRootMenuItem();

        $menu->addChild('main.home', ['route' => 'homepage']);
        $menu->addChild('main.applications', ['route' => 'application_index']);

        $this->addChildConditionally(
            $menu,
            'main.users',
            ['route' => 'user_index'],
            $isSuperAdmin
        );

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    private function getMenuForAnonymousUser(): ItemInterface
    {
        return $this->createRootMenuItem();
    }
}
