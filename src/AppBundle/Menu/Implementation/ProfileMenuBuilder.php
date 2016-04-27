<?php

namespace AppBundle\Menu\Implementation;

use AppBundle\Menu\MenuBuilder;
use Knp\Menu\ItemInterface;

class ProfileMenuBuilder extends MenuBuilder
{
    /**
     * @param array $options
     * @return ItemInterface
     */
    public function build(array $options)
    {
        $menu = $this->createRootItem($this->getMenuClass($options));

        $menu
            ->addChild('profile.edit', ['route' => 'fos_user_profile_edit'])
            ->setAttribute('icon-pre', 'fa fa-pencil');

        $menu
            ->addChild('profile.changePassword', ['route' => 'fos_user_change_password'])
            ->setAttribute('icon-pre', 'fa fa-key');

        return $menu;
    }
}