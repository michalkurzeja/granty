<?php

namespace AppBundle\Listener\Attachment;

use AppBundle\Entity\Attachment;
use AppBundle\Listener\Attachment\Abstraction\VicUploaderEventListenerAbstract;
use Vich\UploaderBundle\Event\Event as VichUploaderEvent;

class AttachmentOriginalNameListener extends VicUploaderEventListenerAbstract
{
    public function saveOriginalName(VichUploaderEvent $event)
    {
        if (!$this->isMappingName('attachment', $event)) {
            return;
        }

        /** @var Attachment $attachment */
        $attachment = $event->getObject();

        $attachment->setOriginalName($attachment->getFile()->getClientOriginalName());
    }
}