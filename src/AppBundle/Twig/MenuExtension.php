<?php

namespace AppBundle\Twig;

use Knp\Menu\ItemInterface;

class MenuExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('menu', [$this, 'menu'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @param \Twig_Environment     $env
     * @param ItemInterface|string  $menu
     * @param array                 $options
     * @param string                $renderer
     *
     * @return string
     */
    public function menu(\Twig_Environment $env, $menu, array $options = [], $renderer = null)
    {
        $menuGet = $env->getFunction('knp_menu_get')->getCallable();
        $menuRender = $env->getFunction('knp_menu_render')->getCallable();

        return $menuRender($menuGet($menu, [], $options), $options, $renderer);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'menu';
    }
}