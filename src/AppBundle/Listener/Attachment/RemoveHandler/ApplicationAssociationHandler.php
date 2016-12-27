<?php

namespace AppBundle\Listener\Attachment\RemoveHandler;

use AppBundle\Entity\Attachment;
use AppBundle\Listener\Abstraction\RemoveHandler\RemoveHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\PreRemove;

class ApplicationAssociationHandler implements RemoveHandler
{
    /**
     * @PreRemove
     *
     * @param Attachment $attachment
     * @param LifecycleEventArgs $event
     */
    public function handle($attachment, LifecycleEventArgs $event): void
    {
        $attachment->getApplication()->clearAttachments();
    }
}
