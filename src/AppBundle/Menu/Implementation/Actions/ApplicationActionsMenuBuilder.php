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
            ['route' => $this->getListRoute($application)],
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
                $item = $this->addChildConditionally(
                    $menu,
                    'actions.application.submit',
                    ['route' => 'application_submit', 'routeParameters' => ['application' => $application->getId()]],
                    $this->getOption($options, 'include_submit', true)
                );

                if ($item instanceof ItemInterface) {
                    $item
                        ->setAttribute('form', true)
                        ->setAttribute('form_btn_type', 'warning');
                }
            }

            if ($this->isAcceptable($application)) {
                $item = $this->addChildConditionally(
                    $menu,
                    'actions.application.accept',
                    ['route' => 'application_accept', 'routeParameters' => ['application' => $application->getId()]],
                    $this->getOption($options, 'include_accept', true)
                );

                if ($item instanceof ItemInterface) {
                    $item
                        ->setAttribute('form', true)
                        ->setAttribute('form-confirm', false)
                        ->setAttribute('form_btn_type', 'success');
                }
            }

            if ($this->isRejectable($application)) {
                $item = $this->addChildConditionally(
                    $menu,
                    'actions.application.reject',
                    ['route' => 'application_reject', 'routeParameters' => ['application' => $application->getId()]],
                    $this->getOption($options, 'include_reject', true)
                );

                if ($item instanceof ItemInterface) {
                    $item
                        ->setAttribute('form', true)
                        ->setAttribute('form-confirm', false)
                        ->setAttribute('form_btn_type', 'alert');
                }
            }

            if ($this->isAppealable($application)) {
                $item = $this->addChildConditionally(
                    $menu,
                    'actions.application.appeal',
                    ['route' => 'application_appeal', 'routeParameters' => ['application' => $application->getId()]],
                    $this->getOption($options, 'include_appeal', true)
                );

                if ($item instanceof ItemInterface) {
                    $item
                        ->setAttribute('form', true)
                        ->setAttribute('form-confirm', false)
                        ->setAttribute('form_btn_type', 'warning');
                }
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
        return $this->applicationWorkflow->isSubmittable($application)
            && $this->isOwnedByCurrentUser($application);
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isAppealable(Application $application): bool
    {
        return $this->applicationWorkflow->isAppealable($application)
            && $this->isOwnedByCurrentUser($application);
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
        return $application->isOwner($this->getCurrentUser());
    }

    /**
     * @param Application $application
     * @return string
     */
    private function getListRoute(?Application $application): string
    {
        if ($application instanceof Application) {
            return $this->isOwnedByCurrentUser($application)
                ? 'application_index'
                : 'application_review_list';
        }

        return 'application_index';
    }
}
