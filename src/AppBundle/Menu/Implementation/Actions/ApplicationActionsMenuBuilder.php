<?php

namespace AppBundle\Menu\Implementation\Actions;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Menu\MenuBuilder;
use AppBundle\Service\Util\CurrentUserProvider\CurrentUserProvider;
use AppBundle\Service\Workflow\Application\ApplicationWorkflow;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class ApplicationActionsMenuBuilder extends MenuBuilder
{
    /** @var ApplicationWorkflow */
    private $applicationWorkflow;

    /**
     * @param FactoryInterface    $factory
     * @param CurrentUserProvider $currentUserProvider
     * @param ApplicationWorkflow $applicationWorkflow
     */
    public function __construct(
        FactoryInterface $factory,
        CurrentUserProvider $currentUserProvider,
        ApplicationWorkflow $applicationWorkflow
    ) {
        parent::__construct($factory, $currentUserProvider);

        $this->applicationWorkflow = $applicationWorkflow;
    }

    /**
     * @param array $options
     * @return ItemInterface
     */
    public function build(array $options): ItemInterface
    {
        /** @var Application $application */
        $application = $options['application'] ?? null;

        $menu = $this->createRootItem($this->getMenuClass($options));

        $this->addChildConditionally(
            $menu,
            'actions.application.index',
            ['route' => 'application_index'],
            $this->getOption($options, 'include_index', true)
        );

        if ($application instanceof Application) {
            $this->addChildConditionally(
                $menu,
                'actions.application.view',
                ['route' => 'application_view', 'routeParameters' => ['application' => $application->getId()]],
                $this->getOption($options, 'include_view', true)
            );

            if ($this->isEditable($application) && $this->isOwnedByCurrentUser($application)) {
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

            if ($this->isSubmittable($application)) {
                $menu
                    ->addChild('actions.application.submit', [
                        'route' => 'application_submit',
                        'routeParameters' => ['application' => $application->getId()],
                    ])
                    ->setAttribute('form', true)
                    ->setAttribute('form_btn_type', 'warning');
            }

            if ($this->isAcceptable($application)) {
                $menu
                    ->addChild('actions.application.accept', [
                        'route' => 'application_accept',
                        'routeParameters' => ['application' => $application->getId()],
                    ])
                    ->setAttribute('form', true)
                    ->setAttribute('form_btn_type', 'success');
            }
        }

        return $menu;
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isEditable(Application $application): bool
    {
        return $this->applicationWorkflow->isEditable($application);
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isSubmittable(Application $application): bool
    {
        return $this->applicationWorkflow->isSubmittable($application);
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isAcceptable(Application $application): bool
    {
        return $this->applicationWorkflow->isAcceptable($application)
            && !$this->isOwnedByCurrentUser($application);
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isRejectable(Application $application): bool
    {
        return $this->applicationWorkflow->isRejectable($application)
            && !$this->isOwnedByCurrentUser($application);
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isOwnedByCurrentUser(Application $application): bool
    {
        return $application->getUser() === $this->getCurrentUser();
    }
}
