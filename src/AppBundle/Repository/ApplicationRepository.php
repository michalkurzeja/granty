<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Enums\ApplicationStatus;
use AppBundle\Service\Filters\Filters;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class ApplicationRepository extends EntityRepository
{
    /**
     * @param User    $user
     * @param Filters $filters
     * @return Query
     * @internal param array $parameters
     */
    public function findAllByUserQuery(User $user, Filters $filters): Query
    {
        $builder = $this->createQueryBuilder('a');

        $this->applyFilters($builder, $filters);

        return $builder
            ->andWhere('a.createdBy = :user')->setParameter('user', $user)
            ->orderBy('a.id')
            ->getQuery();
    }

    /**
     * @param User $user
     * @return QueryBuilder
     */
    public function getFindAllReviewableQueryBuilder(User $user): QueryBuilder
    {
        $builder = $this->createQueryBuilder('a');

        return $builder
            ->andWhere('a.status = :reviewableStatus')->setParameter('reviewableStatus', ApplicationStatus::SUBMITTED())
            ->andWhere('a.createdBy != :user')->setParameter('user', $user);
    }

    /**
     * @param User    $user
     * @param Filters $filters
     * @return Query
     */
    public function findAllReviewableQuery(User $user, Filters $filters): Query
    {
        $builder = $this->getFindAllReviewableQueryBuilder($user);

        $this->applyFilters($builder, $filters);

        return $builder
            ->orderBy('a.id')
            ->getQuery();
    }

    /**
     * @param QueryBuilder $builder
     * @param Filters      $filters
     */
    private function applyFilters(QueryBuilder $builder, Filters $filters): void
    {
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'id':
                case 'status':
                    $builder->andWhere($builder->expr()->eq("a.$key", $builder->expr()->literal($value)));
                    break;
                case 'topic':
                    $builder->andWhere($builder->expr()->like("a.$key", $builder->expr()->literal("%$value%")));
                    break;
                case 'createdBy':
                    $builder
                        ->leftJoin('a.createdBy', 'u')
                        ->andWhere($builder->expr()->like("CONCAT(u.firstName, ' ', u.lastName)", $builder->expr()->literal("%$value%")));
                    break;
            }
        }
    }

    /**
     * @param User $user
     * @return int
     */
    public function getReviewableCount(User $user): int
    {
        return $this->getFindAllReviewableQueryBuilder($user)
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Application[]
     */
    public function findAllReviewable(): array
    {
        $builder = $this->createQueryBuilder('a');

        return $builder
            ->andWhere('a.status = :reviewableStatus')
            ->setParameter('reviewableStatus', ApplicationStatus::SUBMITTED())
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
            ->andWhere('a.createdBy = :user')->setParameter('user', $user)
            ->andWhere('a.status = :status')->setParameter('status', (string) $status)
            ->orderBy('a.id')
            ->getQuery()
            ->getResult();

    }
}
