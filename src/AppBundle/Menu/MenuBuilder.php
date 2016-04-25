<?php

namespace AppBundle\Menu;

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
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * @param FactoryInterface $factory
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(FactoryInterface $factory, TokenStorageInterface $tokenStorage)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
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
        $token = $this->tokenStorage->getToken();

        return $token instanceof TokenInterface
            && $token->getUser() instanceof UserInterface;
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
}