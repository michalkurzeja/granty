<?php
namespace AppBundle\Service\Workflow\Application;

use AppBundle\Entity\Application;
use AppBundle\Enums\ApplicationTransition;
use Symfony\Component\Workflow\Workflow;

class ApplicationWorkflow extends Workflow
{
    /**
     * @param Application $application
     * @return bool
     */
    public function isEditable(Application $application): bool
    {
        return $this->isSubmittable($application);
    }

    /**
     * @param Application $application
     * @return bool
     */
    public function isSubmittable(Application $application): bool
    {
        return $this->can($application, ApplicationTransition::SUBMIT);
    }

    /**
     * @param Application $application
     * @return bool
     */
    public function isAcceptable(Application $application): bool
    {
        return $this->can($application, ApplicationTransition::ACCEPT);
    }

    /**
     * @param Application $application
     * @return bool
     */
    public function isRejectable(Application $application): bool
    {
        return $this->can($application, ApplicationTransition::REJECT);
    }

    /**
     * @param Application $application
     * @return bool
     */
    public function isAppealable(Application $application): bool
    {
        return $this->can($application, ApplicationTransition::APPEAL);
    }
}
