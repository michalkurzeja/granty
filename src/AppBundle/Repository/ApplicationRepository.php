<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Enums\ApplicationStatus;

class ApplicationRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return Application[]
     */
    public function findAllReviewableAndOfUser(User $user): array
    {
        $builder = $this->createQueryBuilder('a');

        return $builder
            ->andWhere(
                $builder->expr()->orX(
                    'a.status IN (:reviewableStatuses)',
                    'a.user = :user'
                )
            )
            ->setParameter('reviewableStatuses', [ApplicationStatus::SUBMITTED, ApplicationStatus::REJECTED])
            ->setParameter('user', $user)
            ->orderBy('a.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Application[]
     */
    public function findAllReviewable(): array
    {
        $builder = $this->createQueryBuilder('a');

        return $builder
            ->andWhere('a.status IN (:reviewableStatuses)')
            ->setParameter('reviewableStatuses', [ApplicationStatus::SUBMITTED, ApplicationStatus::REJECTED])
            ->orderBy('a.id')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User              $user
     * @param ApplicationStatus $status
     * @return Application[]
     */
    public function findAllByUserAndStatus(User $user, ApplicationStatus $status): array
    {
        $builder = $this->createQueryBuilder('a');

        return $builder
            ->andWhere('a.user = :user')->setParameter('user', $user)
            ->andWhere('a.status = :status')->setParameter('status', (string) $status)
            ->orderBy('a.id')
            ->getQuery()
            ->getResult();

    }
}
