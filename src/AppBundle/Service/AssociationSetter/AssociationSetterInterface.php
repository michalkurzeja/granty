<?php

namespace AppBundle\Service\AssociationSetter;

interface AssociationSetterInterface
{
    /**
     * @param object $first
     * @param object $second
     * @return void
     */
    public function set($first, $second): void;
}
