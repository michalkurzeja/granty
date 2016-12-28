<?php
namespace AppBundle\Entity\Traits;

use AppBundle\Entity\Interfaces\BlameableInterface;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait BlameableTrait
{
    /**
     * @var User $createdBy
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $createdBy;

    /**
     * @var User $updatedBy
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $updatedBy;

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $user
     * @return BlameableInterface
     */
    public function setCreatedBy(User $user): BlameableInterface
    {
        $this->createdBy = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    /**
     * @param User $user
     * @return BlameableInterface
     */
    public function setUpdatedBy(User $user): BlameableInterface
    {
        $this->updatedBy = $user;

        return $this;
    }
}
