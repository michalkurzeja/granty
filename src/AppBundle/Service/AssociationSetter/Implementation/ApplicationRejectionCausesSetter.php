<?php

namespace AppBundle\Service\AssociationSetter\Implementation;

use AppBundle\Entity\Application;
use AppBundle\Entity\RejectionCause;
use AppBundle\Service\AssociationSetter\AssociationSetterInterface;

class ApplicationRejectionCausesSetter implements AssociationSetterInterface
{
    /**
     * @param Application    $application
     * @param RejectionCause $rejectionCause
     *
     * @return void
     */
    public function set($application, $rejectionCause): void
    {
        $application->addRejectionCause($rejectionCause);
        $rejectionCause->setApplication($application);
    }
}
