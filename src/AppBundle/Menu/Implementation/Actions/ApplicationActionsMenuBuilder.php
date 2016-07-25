<?php

namespace AppBundle\Menu\Implementation\Actions;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Menu\MenuBuilder;
use Knp\Menu\ItemInterface;

class ApplicationActionsMenuBuilder extends MenuBuilder
{
    /**
     * @param array $options
     * @return ItemInterface
     */
    public function build(array $options)
    {
        /** @var Application $application */
        $application = $options['application'];

        $menu = $this->createRootItem($this->getMenuClass($options));

        $this->addChildConditionally(
            $menu,
            'actions.application.index',
            ['route' => 'application_index'],
            $this->getOption($options, 'include_index', true)
        );

        $this->addChildConditionally(
            $menu,
            'actions.application.view',
            ['route' => 'application_view', 'routeParameters' => ['application' => $application->getId()]],
            $this->getOption($options, 'include_view', true)
        );

        if ($application->isEditable() && $this->isOwnedByCurrentUser($application)) {
            $this->addChildConditionally(
                $menu,
                'actions.application.edit',
                ['route' => 'application_edit', 'routeParameters' => ['application' => $application->getId()]],
                $this->getOption($options, 'include_edit', true)
            );

            $menu
                ->addChild('actions.application.remove', [
                    'route' => 'application_remove',
                    'routeParameters' => ['application' => $application->getId()],
                ])
                ->setAttribute('form', true)
                ->setAttribute('form_btn_type', 'alert')
            ;
        }

        return $menu;
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isOwnedByCurrentUser(Application $application)
    {
        return $application->getUser() === $this->getCurrentUser();
    }
}