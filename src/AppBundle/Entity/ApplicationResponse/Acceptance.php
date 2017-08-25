<?php
namespace AppBundle\Entity\ApplicationResponse;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Acceptance extends AbstractApplicationResponse
{
    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     */
    private $granted = 0;

    /**
     * @return float
     */
    public function getGranted(): float
    {
        return $this->granted;
    }

    /**
     * @param float $granted
     *
     * @return Acceptance
     */
    public function setGranted(float $granted)
    {
        $this->granted = $granted;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'acceptance';
    }
}
