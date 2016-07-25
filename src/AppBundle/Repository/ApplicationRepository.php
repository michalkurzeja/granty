<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Application;
use AppBundle\Enums\ApplicationStatus;

class ApplicationRepository extends EntityRepository
{
    /**
     * @return Application[]
     */
    public function findAllReviewable()
    {
        $builder = $this->createQueryBuilder('a');

        return $builder
            ->andWhere('a.status IN (:reviewableStatuses)')
            ->setParameter('reviewableStatuses', [ApplicationStatus::reviewableStatuses()])
            ->getQuery()
            ->getResult();
    }
}