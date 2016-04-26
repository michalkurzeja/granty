<?php

namespace AppBundle\Menu\Implementation\Actions;

use AppBundle\Entity\Application;
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

        $menu = $this->createRootListItem();

        if ($application->isEditable()) {
            $menu->addChild('actions.application.edit', [
                'route' => 'application_edit',
                'routeParameters' => ['application' => $application->getId()]
            ]);

            $menu
                ->addChild('actions.application.remove', [
                    'route' => 'application_remove',
                    'routeParameters' => ['application' => $application->getId()]
                ])
                ->setAttribute('form', true)
                ->setAttribute('form_btn_type', 'alert')
            ;
        }

        return $menu;
    }
}