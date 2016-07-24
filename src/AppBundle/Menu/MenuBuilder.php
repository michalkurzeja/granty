<?php

namespace AppBundle\Menu;

use AppBundle\Entity\User;
use AppBundle\Service\Util\CurrentUserProvider\CurrentUserProvider;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
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
     * @return User|null
     */
    protected function getCurrentUser()
    {
        return $this->currentUserProvider->getCurrentUser();
    }

    /**
     * @return ItemInterface
     */
    protected function createRootMenuItem()
    {
        return $this->createRootItem('menu');
    }

    /**
     * @return ItemInterface
     */
    protected function createRootListItem()
    {
        return $this->createRootItem('unsigned');
    }

    /**
     * @param string $class
     * @return ItemInterface
     */
    protected function createRootItem($class = '')
    {
        $menu = $this->getFactory()->createItem('root');
        $menu->setChildrenAttribute('class', $class);

        return $menu;
    }

    /**
     * @param array $options
     * @return string
     */
    protected function getMenuClass(array $options)
    {
        return isset($options['class'])
            ? $options['class']
            : 'unsigned';
    }

    /**
     * @param array $options
     * @param string $option
     * @param mixed $default
     * @return mixed
     */
    protected function getOption(array $options, $option, $default)
    {
        return isset($options[$option])
            ? $options[$option]
            : $default;
    }

    /**
     * @param ItemInterface $menu
     * @param $child
     * @param array $options
     * @param $condition
     */
    protected function addChildConditionally(ItemInterface $menu, $child, array $options = array(), $condition)
    {
        if ($condition) {
            $menu->addChild($child, $options);
        }
    }
}