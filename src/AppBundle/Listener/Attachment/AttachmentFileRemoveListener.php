<?php

namespace AppBundle\Listener\Attachment;

use AppBundle\Listener\Attachment\Abstraction\VicUploaderEventListenerAbstract;
use Doctrine\ORM\EntityManagerInterface;
use Vich\UploaderBundle\Event\Event as VichUploaderEvent;

class AttachmentFileRemoveListener extends VicUploaderEventListenerAbstract
{
    /** @var EntityManagerInterface */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function removeAttachment(VichUploaderEvent $event): void
    {
        if (!$this->isMappingName('attachment', $event)) {
            return;
        }

        $this->manager->remove($event->getObject());
    }
}
