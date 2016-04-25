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
    public function build(array $options)
    {
        if (!$this->isUserLogged()) {
            return $this->getMenuForAnonymousUser();
        }

        $menu = $this->createRootItem();

        $menu
            ->addChild('user.profile', ['route' => 'fos_user_profile_show']);

        $menu
            ->addChild('user.logout', ['route' => 'fos_user_security_logout'])
            ->setAttribute('icon-post', 'fa fa-sign-out');

        return $menu;
    }

    private function getMenuForAnonymousUser()
    {
        $menu = $this->createRootItem();

        $menu
            ->addChild('user.login', ['route' => 'fos_user_security_login'])
            ->setAttribute('icon-post', 'fa fa-sign-in');

        return $menu;
    }
}