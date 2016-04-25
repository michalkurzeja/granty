<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 */
class Application
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
    private $meritoricJustification;

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
    private $forseeableGoals;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $scheduleOfWork;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $financialSources;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="applications")
     */
    private $user;

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
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
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
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getMeritoricJustification()
    {
        return $this->meritoricJustification;
    }

    /**
     * @param string $meritoricJustification
     */
    public function setMeritoricJustification($meritoricJustification)
    {
        $this->meritoricJustification = $meritoricJustification;
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
    public function setCurrentKnowledge($currentKnowledge)
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
    public function setScientificAchievements($scientificAchievements)
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
    public function setApplicantsProjects($applicantsProjects)
    {
        $this->applicantsProjects = $applicantsProjects;
    }

    /**
     * @return string
     */
    public function getForseeableGoals()
    {
        return $this->forseeableGoals;
    }

    /**
     * @param string $forseeableGoals
     */
    public function setForseeableGoals($forseeableGoals)
    {
        $this->forseeableGoals = $forseeableGoals;
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
    public function setScheduleOfWork($scheduleOfWork)
    {
        $this->scheduleOfWork = $scheduleOfWork;
    }

    /**
     * @return string
     */
    public function getFinancialSources()
    {
        return $this->financialSources;
    }

    /**
     * @param string $financialSources
     */
    public function setFinancialSources($financialSources)
    {
        $this->financialSources = $financialSources;
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
    public function setPlannedExpensesTotal($plannedExpensesTotal)
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
    public function setPlannedExpensesInCurrentYear($plannedExpensesInCurrentYear)
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
    public function setExpensesExplanation($expensesExplanation)
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
    public function setProjectDirector($projectDirector)
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
    public function setOrganizationDirector($organizationDirector)
    {
        $this->organizationDirector = $organizationDirector;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}