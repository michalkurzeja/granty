<?php

namespace AppBundle\Service\Util\UserPasswordManager;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordManager
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function encodeAndSetPassword(User $user)
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
    }
}