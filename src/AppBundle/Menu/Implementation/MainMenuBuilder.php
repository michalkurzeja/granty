<?php

namespace AppBundle\Menu\Implementation;

use AppBundle\Entity\User;
use AppBundle\Menu\MenuBuilder;
use AppBundle\Repository\ApplicationRepository;
use AppBundle\Service\Util\CurrentUserProvider\CurrentUserProvider;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MainMenuBuilder extends MenuBuilder
{
    /** @var ApplicationRepository */
    private $applicationRepository;

    /**
     * @param FactoryInterface      $factory
     * @param CurrentUserProvider   $currentUserProvider
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(
        FactoryInterface $factory,
        CurrentUserProvider $currentUserProvider,
        ApplicationRepository $applicationRepository
    ) {
        parent::__construct($factory, $currentUserProvider);

        $this->applicationRepository = $applicationRepository;
    }

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
            ->addChild('main.home', ['route' => 'homepage'])
            ->setAttribute('icon-pre', 'fa fa-home');

        $item = $this->addChildConditionally(
            $menu,
            'main.applications',
            ['route' => 'application_index'],
            !$this->isCurrentUserASuperAdmin()
        );

        if ($item instanceof ItemInterface) {
            $item->setAttribute('icon-pre', 'fa fa-list');
        }

        $item = $this->addChildConditionally(
            $menu,
            'main.review_list',
            ['route' => 'application_review_list'],
            $this->isCurrentUserAReviewer()
        );

        if ($item instanceof ItemInterface) {
            $item
                ->setAttribute('icon-pre', 'fa fa-th-list')
                ->setAttribute('badge-post', $this->applicationRepository->getReviewableCount($this->getCurrentUser()))
                ->setAttribute('badge-class', 'warning');
        }

        $item = $this->addChildConditionally(
            $menu,
            'main.users',
            ['route' => 'user_index'],
            $this->isCurrentUserASuperAdmin()
        );

        if ($item instanceof ItemInterface) {
            $item->setAttribute('icon-pre', 'fa fa-users');
        }

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    private function getMenuForAnonymousUser(): ItemInterface
    {
        return $this->createRootMenuItem();
    }

    /**
     * @return bool
     */
    private function isCurrentUserAReviewer(): bool
    {
        $user = $this->getCurrentUser();

        if ($user instanceof User) {
            return $user->isReviewer();
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isCurrentUserASuperAdmin(): bool
    {
        $user = $this->getCurrentUser();

        if ($user instanceof User) {
            return $user->isSuperAdmin();
        }

        return false;
    }
}
