<?php
namespace AppBundle\Entity\Interfaces;

use AppBundle\Entity\User;

interface BlameableInterface
{
    /**
     * @return User
     */
    public function getCreatedBy(): User;

    /**
     * @param User $user
     * @return BlameableInterface
     */
    public function setCreatedBy(User $user): BlameableInterface;

    /**
     * @return User
     */
    public function getUpdatedBy(): User;

    /**
     * @param User $user
     * @return BlameableInterface
     */
    public function setUpdatedBy(User $user): BlameableInterface;
}
