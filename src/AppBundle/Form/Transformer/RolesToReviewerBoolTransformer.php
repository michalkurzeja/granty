<?php
namespace AppBundle\Form\Transformer;

use AppBundle\Entity\User;
use Symfony\Component\Form\DataTransformerInterface;

class RolesToReviewerBoolTransformer implements DataTransformerInterface
{
    /**
     * @param string[] $value
     * @return bool
     */
    public function transform($value)
    {
        return in_array(User::ROLE_REVIEWER, $value);
    }

    /**
     * @param bool $value
     * @return string[] array
     */
    public function reverseTransform($value)
    {
        return $value
            ? [User::ROLE_REVIEWER]
            : [User::ROLE_DEFAULT];
    }
}