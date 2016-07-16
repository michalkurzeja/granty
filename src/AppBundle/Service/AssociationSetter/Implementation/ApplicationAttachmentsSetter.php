<?php

namespace AppBundle\Service\AssociationSetter\Implementation;

use AppBundle\Entity\Application;
use AppBundle\Entity\Attachment;
use AppBundle\Entity\User;
use AppBundle\Service\AssociationSetter\AssociationSetterInterface;

class ApplicationAttachmentsSetter implements AssociationSetterInterface
{
    /**
     * @param Application $application
     * @param Attachment $attachment
     * @return void
     */
    public function set($application, $attachment)
    {
        if ($application instanceof Application) {
            $application->setAttachment($attachment);
        }

        if ($attachment instanceof Attachment) {
            $attachment->setApplication($application);
        }
    }
}