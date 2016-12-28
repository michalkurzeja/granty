<?php
namespace AppBundle\Entity\Interfaces;

use DateTime;

interface TimestampableInterface
{
    /**
     * @return DateTime
     */
    public function getCreated(): DateTime;

    /**
     * @param DateTime $created
     * @return TimestampableInterface
     */
    public function setCreated(DateTime $created): TimestampableInterface;

    /**
     * @return DateTime
     */
    public function getUpdated(): ?DateTime;

    /**
     * @param DateTime $updated
     * @return TimestampableInterface
     */
    public function setUpdated(DateTime $updated): TimestampableInterface;
}
