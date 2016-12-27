<?php
namespace AppBundle\Service\Application;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Enums\ApplicationStatus;
use AppBundle\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class SubmittedApplicationsRetriever
{
    /** @var ApplicationRepository */
    private $applicationRepository;

    /**
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * @param User $user
     * @return Collection | Application[]
     */
    public function getSubmittedApplications(User $user): Collection
    {
        return new ArrayCollection(
            $this->applicationRepository->findAllByUserAndStatus($user, ApplicationStatus::SUBMITTED())
        );
    }
}
