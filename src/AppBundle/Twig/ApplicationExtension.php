<?php
namespace AppBundle\Twig;

use AppBundle\Entity\User;
use AppBundle\Enums\ApplicationStatus;
use AppBundle\Service\Application\SubmittedApplicationsRetriever;
use Doctrine\Common\Collections\Collection;
use Twig_Extension;
use Twig_SimpleFunction;

class ApplicationExtension extends Twig_Extension
{
    /** @var SubmittedApplicationsRetriever */
    private $submittedApplicationsRetriever;

    /**
     * @param SubmittedApplicationsRetriever $submittedApplicationsRetriever
     */
    public function __construct(SubmittedApplicationsRetriever $submittedApplicationsRetriever)
    {
        $this->submittedApplicationsRetriever = $submittedApplicationsRetriever;
    }

    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new Twig_SimpleFunction('submitted_applications', [$this, 'getSubmittedApplications']),
            new Twig_SimpleFunction('application_statuses', [$this, 'getApplicationStatuses']),
        ];
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getSubmittedApplications(User $user): Collection
    {
        return $this->submittedApplicationsRetriever->getSubmittedApplications($user);
    }

    /**
     * @return array
     */
    public function getApplicationStatuses(): array
    {
        return ApplicationStatus::values();
    }

    public function getName(): string
    {
        return 'application';
    }
}
