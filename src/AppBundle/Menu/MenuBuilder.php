<?php

namespace AppBundle\Menu;

use AppBundle\Service\Util\CurrentUserProvider\CurrentUserProvider;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class MenuBuilder
{
    /**
     * @param array $options
     * @return ItemInterface
     */
    public abstract function build(array $options);

    /** @var FactoryInterface */
    private $factory;
    /** @var CurrentUserProvider */
    private $currentUserProvider;

    /**
     * @param FactoryInterface $factory
     * @param CurrentUserProvider $currentUserProvider
     */
    public function __construct(FactoryInterface $factory, CurrentUserProvider $currentUserProvider)
    {
        $this->factory = $factory;
        $this->currentUserProvider = $currentUserProvider;
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return bool
     */
    protected function isUserLogged()
    {
        $user = $this->currentUserProvider->getCurrentUser();

        return $user instanceof UserInterface;
    }

    /**
     * @return ItemInterface
     */
    protected function createRootItem()
    {
        $menu = $this->getFactory()->createItem('root');
        $menu->setChildrenAttribute('class', 'menu');

        return $menu;
    }

    /**
     * @return ItemInterface
     */
    protected function createRootListItem()
    {
        $menu = $this->getFactory()->createItem('root');

        return $menu;
    }
}