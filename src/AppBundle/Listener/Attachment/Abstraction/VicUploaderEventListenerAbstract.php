<?php

namespace AppBundle\Listener\Attachment\Abstraction;

use Vich\UploaderBundle\Event\Event as VichUploaderEvent;

abstract class VicUploaderEventListenerAbstract
{
    protected function isMappingName($mappingName, VichUploaderEvent $event)
    {
        return $this->getMappingName($event) === $mappingName;
    }

    /**
     * @param VichUploaderEvent $event
     * @return string
     */
    protected function getMappingName(VichUploaderEvent $event)
    {
        return $event->getMapping()->getMappingName();
    }
}