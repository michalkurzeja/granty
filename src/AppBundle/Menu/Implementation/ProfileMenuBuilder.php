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
    public function build(array $options): ItemInterface
    {
        $menu = $this->createRootItem($this->getMenuClass($options));

        $item = $this->addChildConditionally(
            $menu,
            'profile.view',
            ['route' => 'fos_user_profile_show'],
            $this->getOption($options, 'include_view', true)
        );

        if ($item) {
            $item->setAttribute('icon-pre', 'fa fa-eye');
        }

        $item = $this->addChildConditionally(
            $menu,
            'profile.edit',
            ['route' => 'fos_user_profile_edit'],
            $this->getOption($options, 'include_edit', true)
        );

        if ($item) {
            $item->setAttribute('icon-pre', 'fa fa-pencil');
        }

        $item = $this->addChildConditionally(
            $menu,
            'profile.changePassword',
            ['route' => 'fos_user_change_password'],
            $this->getOption($options, 'include_change_password', true)
        );

        if ($item) {
            $item->setAttribute('icon-pre', 'fa fa-key');
        }

        return $menu;
    }
}
