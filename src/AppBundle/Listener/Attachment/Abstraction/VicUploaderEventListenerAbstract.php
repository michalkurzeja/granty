<?php

namespace AppBundle\Listener\Attachment\Abstraction;

use Vich\UploaderBundle\Event\Event as VichUploaderEvent;

abstract class VicUploaderEventListenerAbstract
{
    /**
     * @param string            $mappingName
     * @param VichUploaderEvent $event
     * @return bool
     */
    protected function isMappingName(string $mappingName, VichUploaderEvent $event): bool
    {
        return $this->getMappingName($event) === $mappingName;
    }

    /**
     * @param VichUploaderEvent $event
     * @return string
     */
    protected function getMappingName(VichUploaderEvent $event): string
    {
        return $event->getMapping()->getMappingName();
    }
}
