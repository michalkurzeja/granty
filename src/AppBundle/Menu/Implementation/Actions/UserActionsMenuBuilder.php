<?php

namespace AppBundle\Menu\Implementation\Actions;

use AppBundle\Entity\User;
use AppBundle\Menu\MenuBuilder;
use Knp\Menu\ItemInterface;

class UserActionsMenuBuilder extends MenuBuilder
{
    /**
     * @param array $options
     * @return ItemInterface
     */
    public function build(array $options)
    {
        /** @var User $user */
        $user = $options['user'];

        $menu = $this->createRootItem($this->getMenuClass($options));

        $this->addChildConditionally(
            $menu,
            'actions.user.index',
            ['route' => 'user_index'],
            $this->getOption($options, 'include_index', true)
        );

        $this->addChildConditionally(
            $menu,
            'actions.user.view',
            ['route' => 'user_view', 'routeParameters' => ['user' => $user->getId()]],
            $this->getOption($options, 'include_view', true)
        );

        $this->addChildConditionally(
            $menu,
            'actions.user.edit',
            ['route' => 'user_edit', 'routeParameters' => ['user' => $user->getId()]],
            $this->getOption($options, 'include_edit', true)
        );

        $menu
            ->addChild('actions.user.remove', [
                'route' => 'user_remove',
                'routeParameters' => ['user' => $user->getId()],
            ])
            ->setAttribute('form', true)
            ->setAttribute('form_btn_type', 'alert')
        ;

        return $menu;
    }
}