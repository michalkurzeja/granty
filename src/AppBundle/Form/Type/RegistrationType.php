<?php

namespace AppBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType;

class RegistrationType extends ProfileType
{
    /**
     * @return string
     */
    public function getParent()
    {
        return RegistrationFormType::class;
    }
}