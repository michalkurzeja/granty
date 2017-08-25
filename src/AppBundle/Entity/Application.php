<?php

namespace AppBundle\Entity;

use AppBundle\Entity\ApplicationResponse\AbstractApplicationResponse;
use AppBundle\Entity\ApplicationResponse\Appeal;
use AppBundle\Entity\ApplicationResponse\RejectionCause;
use AppBundle\Entity\Interfaces\TraceableInterface;
use AppBundle\Entity\Traits\TraceableTrait;
use AppBundle\Enums\ApplicationCategory;
use AppBundle\Enums\ApplicationStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 */
class Application implements TraceableInterface
{
    use TraceableTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $topic;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $meritoricalJustification;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $currentKnowledge;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $scientificAchievements;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $applicantsProjects;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $foreseeableGoals;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $scheduleOfWork;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $externalFinancing;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $plannedExpensesTotal;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $plannedExpensesInCurrentYear;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $expensesExplanation;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $projectDirector;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $organizationDirector;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    /**
     * @var Attachment
     *
     * @ORM\OneToOne(targetEntity="Attachment", mappedBy="application", cascade={"persist", "remove"})
     */
    private $attachment;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\ApplicationResponse\AbstractApplicationResponse",
     *     mappedBy="application",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     * @ORM\OrderBy({"created": "desc"})
     * @Assert\Valid
     */
    private $responses;

    public function __construct()
    {
        $this->setStatus(ApplicationStatus::DRAFT());
        $this->setResponses(new ArrayCollection());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null | ApplicationCategory
     */
    public function getCategory()
    {
        if (!$this->category) {
            return null;
        }

        return new ApplicationCategory($this->category);
    }

    /**
     * @param ApplicationCategory $category
     *
     * @return Application
     */
    public function setCategory(?ApplicationCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic(string $topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getMeritoricalJustification()
    {
        return $this->meritoricalJustification;
    }

    /**
     * @param string $meritoricalJustification
     */
    public function setMeritoricalJustification(?string $meritoricalJustification)
    {
        $this->meritoricalJustification = $meritoricalJustification;
    }

    /**
     * @return string
     */
    public function getCurrentKnowledge()
    {
        return $this->currentKnowledge;
    }

    /**
     * @param string $currentKnowledge
     */
    public function setCurrentKnowledge(?string $currentKnowledge)
    {
        $this->currentKnowledge = $currentKnowledge;
    }

    /**
     * @return string
     */
    public function getScientificAchievements()
    {
        return $this->scientificAchievements;
    }

    /**
     * @param string $scientificAchievements
     */
    public function setScientificAchievements(?string $scientificAchievements)
    {
        $this->scientificAchievements = $scientificAchievements;
    }

    /**
     * @return string
     */
    public function getApplicantsProjects()
    {
        return $this->applicantsProjects;
    }

    /**
     * @param string $applicantsProjects
     */
    public function setApplicantsProjects(?string $applicantsProjects)
    {
        $this->applicantsProjects = $applicantsProjects;
    }

    /**
     * @return string
     */
    public function getForeseeableGoals()
    {
        return $this->foreseeableGoals;
    }

    /**
     * @param string $foreseeableGoals
     */
    public function setForeseeableGoals(?string $foreseeableGoals)
    {
        $this->foreseeableGoals = $foreseeableGoals;
    }

    /**
     * @return string
     */
    public function getScheduleOfWork()
    {
        return $this->scheduleOfWork;
    }

    /**
     * @param string $scheduleOfWork
     */
    public function setScheduleOfWork(?string $scheduleOfWork)
    {
        $this->scheduleOfWork = $scheduleOfWork;
    }

    /**
     * @return boolean
     */
    public function isExternalFinancing()
    {
        return $this->externalFinancing;
    }

    /**
     * @param boolean $externalFinancing
     */
    public function setExternalFinancing(bool $externalFinancing)
    {
        $this->externalFinancing = $externalFinancing;
    }

    /**
     * @return float
     */
    public function getPlannedExpensesTotal()
    {
        return $this->plannedExpensesTotal;
    }

    /**
     * @param float $plannedExpensesTotal
     */
    public function setPlannedExpensesTotal(float $plannedExpensesTotal)
    {
        $this->plannedExpensesTotal = $plannedExpensesTotal;
    }

    /**
     * @return float
     */
    public function getPlannedExpensesInCurrentYear()
    {
        return $this->plannedExpensesInCurrentYear;
    }

    /**
     * @param float $plannedExpensesInCurrentYear
     */
    public function setPlannedExpensesInCurrentYear(float $plannedExpensesInCurrentYear)
    {
        $this->plannedExpensesInCurrentYear = $plannedExpensesInCurrentYear;
    }

    /**
     * @return string
     */
    public function getExpensesExplanation()
    {
        return $this->expensesExplanation;
    }

    /**
     * @param string $expensesExplanation
     */
    public function setExpensesExplanation(?string $expensesExplanation)
    {
        $this->expensesExplanation = $expensesExplanation;
    }

    /**
     * @return string
     */
    public function getProjectDirector()
    {
        return $this->projectDirector;
    }

    /**
     * @param string $projectDirector
     */
    public function setProjectDirector(string $projectDirector)
    {
        $this->projectDirector = $projectDirector;
    }

    /**
     * @return string
     */
    public function getOrganizationDirector()
    {
        return $this->organizationDirector;
    }

    /**
     * @param string $organizationDirector
     */
    public function setOrganizationDirector(?string $organizationDirector)
    {
        $this->organizationDirector = $organizationDirector;
    }

    /**
     * @return ApplicationStatus
     */
    public function getStatus()
    {
        return new ApplicationStatus($this->status);
    }

    /**
     * @param ApplicationStatus $status
     */
    private function setStatus(ApplicationStatus $status)
    {
        $this->status = $status->getValue();
    }

    /**
     * @param string $status
     */
    public function setWorkflowStatus(string $status)
    {
        $this->setStatus(new ApplicationStatus($status));
    }

    /**
     * @return string
     */
    public function getWorkflowStatus()
    {
        return (string) $this->getStatus();
    }

    /**
     * @return Attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param Attachment $attachment
     */
    public function setAttachment(?Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @return void
     */
    public function clearAttachments()
    {
        $this->setAttachment(null);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isOwner(User $user)
    {
        return $this->createdBy === $user;
    }

    /**
     * @return bool
     */
    public function isRejected()
    {
        return $this->getStatus()->equals(ApplicationStatus::REJECTED());
    }

    /**
     * @return Collection
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param AbstractApplicationResponse $response
     * @return Application
     */
    public function addResponse(AbstractApplicationResponse $response)
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
        }

        return $this;
    }

    /**
     * @param AbstractApplicationResponse $response
     * @return Application
     */
    public function removeResponse(AbstractApplicationResponse $response)
    {
        $this->responses->removeElement($response);

        return $this;
    }

    /**
     * @param Collection $responses
     *
     * @return Application
     */
    public function setResponses(Collection $responses)
    {
        $this->responses = $responses;

        return $this;
    }
}
