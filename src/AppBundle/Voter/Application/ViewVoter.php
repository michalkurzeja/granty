<?php

namespace AppBundle\Voter\Application;

use AppBundle\Entity\Application;
use AppBundle\Voter\Abstraction\Voter;
use AppBundle\Voter\Actions\VoterActions;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ViewVoter extends Voter
{
    /**
     * @return string[]
     */
    protected function getSupportedTypes(): array
    {
        return [
            Application::class,
        ];
    }

    /**
     * @return string[]
     */
    protected function getSupportedAttributes(): array
    {
        return [
            VoterActions::VIEW,
        ];
    }

    /**
     * @param string $attribute
     * @param Application $application
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $application, TokenInterface $token): bool
    {
        return $this->hasUserAccess($application, $token);
    }

    /**
     * @param Application $application
     * @param TokenInterface $token
     * @return bool
     */
    private function hasUserAccess(Application $application, TokenInterface $token): bool
    {
        return $application->isOwner($token->getUser());
    }
}
