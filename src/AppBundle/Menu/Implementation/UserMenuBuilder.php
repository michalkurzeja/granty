<?php

namespace AppBundle\Menu\Implementation;

use AppBundle\Menu\MenuBuilder;
use Knp\Menu\ItemInterface;

class UserMenuBuilder extends MenuBuilder
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

        $menu = $this->createRootMenuItem();

        $menu
            ->addChild('user.profile', ['route' => 'fos_user_profile_show']);

        $menu
            ->addChild('user.logout', ['route' => 'fos_user_security_logout'])
            ->setAttribute('icon-post', 'fa fa-sign-out');

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    private function getMenuForAnonymousUser(): ItemInterface
    {
        $menu = $this->createRootMenuItem();

        $menu
            ->addChild('user.login', ['route' => 'fos_user_security_login'])
            ->setAttribute('icon-post', 'fa fa-sign-in');

        return $menu;
    }
}
