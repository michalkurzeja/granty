<?php
namespace AppBundle\Voter\Abstraction;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Workflow\Workflow;

abstract class TransitionVoter extends Voter
{
    /** @var Workflow */
    private $workflow;

    /**
     * @param Workflow $workflow
     */
    public function __construct(Workflow $workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * @return Workflow
     */
    protected function getWorkflow(): Workflow
    {
        return $this->workflow;
    }

    /**
     * @param string         $attribute
     * @param mixed          $application
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $application, TokenInterface $token): bool
    {
        return $this->getWorkflow()->can($application, $attribute)
            && $this->voteOnAdditionalConditions($attribute, $application, $token);
    }

    /**
     * @param string         $attribute
     * @param mixed          $application
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAdditionalConditions(string $attribute, $application, TokenInterface $token): bool
    {
        return true;
    }
}
