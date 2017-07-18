<?php

namespace AppBundle\Service\AssociationSetter\Implementation;

use AppBundle\Entity\Appeal;
use AppBundle\Entity\Application;
use AppBundle\Service\AssociationSetter\AssociationSetterInterface;

class ApplicationAppealsSetter implements AssociationSetterInterface
{
    /**
     * @param Application $application
     * @param Appeal      $appeal
     *
     * @return void
     */
    public function set($application, $appeal): void
    {
        $application->addAppeal($appeal);
        $appeal->setApplication($application);
    }
}
