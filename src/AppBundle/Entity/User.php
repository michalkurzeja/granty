<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="app_user")
 */
class User extends BaseUser
{
    const ROLE_REVIEWER = 'ROLE_REVIEWER';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $department;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Date
     */
    private $dateOfBirth;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param string $department
     */
    public function setDepartment(string $department)
    {
        $this->department = $department;
    }

    /**
     * @return DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param DateTime $dateOfBirth
     */
    public function setDateOfBirth(DateTime $dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return bool
     */
    public function isReviewer()
    {
        return in_array(static::ROLE_REVIEWER, $this->getRoles()) || $this->isSuperAdmin();
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullName();
    }
}
