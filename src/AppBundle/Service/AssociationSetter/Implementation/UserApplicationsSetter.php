<?php

namespace AppBundle\Service\AssociationSetter\Implementation;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Service\AssociationSetter\AssociationSetterInterface;

class UserApplicationsSetter implements AssociationSetterInterface
{
    /**
     * @param User $user
     * @param Application $application
     * @return void
     */
    public function set($user, $application)
    {
        $user->addApplication($application);
        $application->setUser($user);
    }
}