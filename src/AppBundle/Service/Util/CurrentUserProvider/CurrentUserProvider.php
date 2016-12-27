<?php

namespace AppBundle\Service\Util\CurrentUserProvider;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CurrentUserProvider
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return User | string | null
     */
    public function getCurrentUser()
    {
        $token = $this->tokenStorage->getToken();

        if (!$token instanceof TokenInterface) {
            return null;
        }

        return $token->getUser();
    }
}
