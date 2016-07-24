<?php

namespace AppBundle\Voter\User;

use AppBundle\Entity\User;
use AppBundle\Voter\Abstraction\Voter;
use AppBundle\Voter\Actions\VoterActions;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ViewVoter extends Voter
{
    /**
     * @return string[]
     */
    protected function getSupportedTypes()
    {
        return [
            User::class,
        ];
    }

    /**
     * @return string[]
     */
    protected function getSupportedAttributes()
    {
        return [
            VoterActions::VIEW,
        ];
    }

    /**
     * @param string $attribute
     * @param User $user
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $user, TokenInterface $token)
    {
        return false;
    }
}