<?php
namespace AppBundle\Entity\Traits;

use AppBundle\Entity\Interfaces\TimestampableInterface;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait TimestampableTrait
{
    /**
     * @var DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return TimestampableInterface
     */
    public function setCreated(DateTime $created): TimestampableInterface
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     * @return TimestampableInterface
     */
    public function setUpdated(DateTime $updated): TimestampableInterface
    {
        $this->updated = $updated;

        return $this;
    }
}
