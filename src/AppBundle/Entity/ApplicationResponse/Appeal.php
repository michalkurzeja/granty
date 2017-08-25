<?php
namespace AppBundle\Entity\ApplicationResponse;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Appeal extends AbstractApplicationResponse
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'appeal';
    }
}
