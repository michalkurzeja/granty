<?php

namespace AppBundle\Voter\User;

use AppBundle\Entity\User;
use AppBundle\Voter\Abstraction\Voter;
use AppBundle\Voter\Actions\VoterActions;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ModifyVoter extends Voter
{
    /**
     * @return string[]
     */
    protected function getSupportedTypes(): array
    {
        return [
            User::class,
        ];
    }

    /**
     * @return string[]
     */
    protected function getSupportedAttributes(): array
    {
        return [
            VoterActions::EDIT,
            VoterActions::REMOVE,
        ];
    }

    /**
     * @param string $attribute
     * @param User $user
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $user, TokenInterface $token): bool
    {
        return $user === $token->getUser() || $token->getUser()->isSuperAdmin();
    }
}
