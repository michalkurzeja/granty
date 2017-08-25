<?php
namespace AppBundle\Entity\ApplicationResponse;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class RejectionCause extends AbstractApplicationResponse
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'rejection_cause';
    }
}
