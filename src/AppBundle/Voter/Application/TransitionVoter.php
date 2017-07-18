<?php
namespace AppBundle\Voter\Application;

use AppBundle\Entity\Application;
use AppBundle\Enums\ApplicationTransition;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use AppBundle\Voter\Abstraction\TransitionVoter as BaseTransitionVoter;

class TransitionVoter extends BaseTransitionVoter
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
            ApplicationTransition::SUBMIT,
            ApplicationTransition::ACCEPT,
            ApplicationTransition::REJECT,
            ApplicationTransition::APPEAL,
        ];
    }

    /**
     * @param string $attribute
     * @param Application $application
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAdditionalConditions(string $attribute, $application, TokenInterface $token): bool
    {
        if (in_array($attribute, [ApplicationTransition::SUBMIT, ApplicationTransition::APPEAL])) {
            return $this->hasUserAccess($application, $token);
        }

        return !$this->hasUserAccess($application, $token);
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
