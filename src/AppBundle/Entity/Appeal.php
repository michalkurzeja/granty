<?php
namespace AppBundle\Entity;

use AppBundle\Entity\Interfaces\TraceableInterface;
use AppBundle\Entity\Traits\TraceableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Appeal implements TraceableInterface
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     *
     * @var string
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Application", inversedBy="appeals")
     *
     * @var Application
     */
    private $application;

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Appeal
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Application $application
     * @return Appeal
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
    }
}
