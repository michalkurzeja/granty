<?php

namespace AppBundle\Service\AssociationSetter\Implementation;

use AppBundle\Entity\ApplicationResponse\AbstractApplicationResponse;
use AppBundle\Entity\Application;
use AppBundle\Service\AssociationSetter\AssociationSetterInterface;

class ApplicationResponsesSetter implements AssociationSetterInterface
{
    /**
     * @param Application                 $application
     * @param AbstractApplicationResponse $response
     *
     * @return void
     */
    public function set($application, $response): void
    {
        $application->addResponse($response);
        $response->setApplication($application);
    }
}
