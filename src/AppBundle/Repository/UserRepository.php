<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * @param string $username
     * @return User | null
     */
    public function loadUserByUsername($username): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param User $user
     * @return User[]
     */
    public function findAllExcept(User $user): array
    {
        $builder = $this->createQueryBuilder('u');

        $builder
            ->andWhere('u != :user')
            ->setParameter('user', $user)
            ->orderBy('u.id')
            ;

        return $builder
            ->getQuery()
            ->getResult();
    }
}
