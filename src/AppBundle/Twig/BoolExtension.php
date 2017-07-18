<?php
namespace AppBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

class BoolExtension extends Twig_Extension
{
    /**
     * @return Twig_SimpleFilter[]
     */
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('bool', [$this, 'bool']),
        ];
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function bool($value): string
    {
        return $value
            ? 'bool.true'
            : 'bool.false';
    }

    public function getName(): string
    {
        return 'bool';
    }
}
