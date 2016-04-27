<?php

namespace AppBundle\Listener\Abstraction\RemoveHandler;

use Doctrine\ORM\Event\LifecycleEventArgs;

interface RemoveHandler
{
    public function handle($entity, LifecycleEventArgs $event);
}