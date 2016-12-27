<?php

namespace AppBundle\Voter\Application;

use AppBundle\Entity\Application;
use AppBundle\Service\Workflow\Application\ApplicationWorkflow;
use AppBundle\Voter\Abstraction\Voter;
use AppBundle\Voter\Actions\VoterActions;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ModifyVoter extends Voter
{
    /** @var ApplicationWorkflow */
    private $applicationWorkflow;

    /**
     * @param ApplicationWorkflow $applicationWorkflow
     */
    public function __construct(ApplicationWorkflow $applicationWorkflow)
    {
        $this->applicationWorkflow = $applicationWorkflow;
    }

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
            VoterActions::EDIT,
            VoterActions::REMOVE,
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
        return $this->isEditable($application) && $this->hasUserAccess($application, $token);
    }

    /**
     * @param Application $application
     * @return bool
     */
    private function isEditable(Application $application): bool
    {
        return $this->applicationWorkflow->isEditable($application);
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
