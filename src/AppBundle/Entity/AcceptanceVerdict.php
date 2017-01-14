<?php
namespace AppBundle\Entity;

use AppBundle\Entity\Interfaces\TraceableInterface;
use AppBundle\Entity\Traits\TraceableTrait;
use AppBundle\Enums\VerdictCategory;

class AcceptanceVerdict implements TraceableInterface
{
    use TraceableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     *
     * @var int
     */
    private $publications;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     *
     * @var int
     */
    private $projects;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     *
     * @var int
     */
    private $applications;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     *
     * @var VerdictCategory
     */
    private $category;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * @param int $publications
     *
     * @return AcceptanceVerdict
     */
    public function setPublications(int $publications)
    {
        $this->publications = $publications;

        return $this;
    }

    /**
     * @return int
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param int $projects
     *
     * @return AcceptanceVerdict
     */
    public function setProjects(int $projects)
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * @return int
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param int $applications
     *
     * @return AcceptanceVerdict
     */
    public function setApplications(int $applications)
    {
        $this->applications = $applications;

        return $this;
    }

    /**
     * @return VerdictCategory
     */
    public function getCategory()
    {
        if (!$this->category) {
            return null;
        }

        return new VerdictCategory($this->category);
    }

    /**
     * @param VerdictCategory $category
     *
     * @return AcceptanceVerdict
     */
    public function setCategory(?VerdictCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->getPublications()
            + $this->getProjects()
            + $this->getApplications();
    }
}
