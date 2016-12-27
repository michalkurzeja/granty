<?php
namespace AppBundle\Twig;

use AppBundle\Entity\User;
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

    public function getName(): string
    {
        return 'application';
    }
}
