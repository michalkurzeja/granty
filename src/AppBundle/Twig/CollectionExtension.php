<?php
namespace AppBundle\Twig;

use Doctrine\Common\Collections\Collection;
use Twig_Extension;
use Twig_SimpleFunction;

class CollectionExtension extends Twig_Extension
{
    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('is_empty', [$this, 'isEmpty']),
        ];
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function isEmpty($value)
    {
        if ($value instanceof Collection) {
            return $value->isEmpty();
        }

        return empty($value);
    }

    public function getName()
    {
        return 'collection';
    }
}