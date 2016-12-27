<?php
namespace AppBundle\Form\Transformer;

use AppBundle\Entity\User;
use Symfony\Component\Form\DataTransformerInterface;

class RolesToReviewerBoolTransformer implements DataTransformerInterface
{
    /** @var string[] */
    private $originalRoles = [];

    /**
     * @param string[] $value
     * @return bool
     */
    public function transform($value): bool
    {
        $this->originalRoles = $value;

        return in_array(User::ROLE_REVIEWER, $value);
    }

    /**
     * @param bool $value
     * @return string[] array
     */
    public function reverseTransform($value): array
    {
        if ($value) {
            return $this->getRolesWithReviewer($this->originalRoles);
        }

        return $this->getRolesWithoutReviewer($this->originalRoles);
    }

    /**
     * @param string[] $roles
     * @return string[]
     */
    private function getRolesWithReviewer(array $roles): array
    {
        foreach ($roles as $role) {
            if (User::ROLE_REVIEWER === $role) {
                return $roles; // The role is already there. No need to do anything.
            }
        }

        $roles[] = User::ROLE_REVIEWER;

        return $roles;
    }

    /**
     * @param string[] $roles
     * @return string[]
     */
    private function getRolesWithoutReviewer(array $roles): array
    {
        foreach ($roles as $key => $role) {
            if (User::ROLE_REVIEWER === $role) {
                unset($roles[$key]);
                return $roles;
            }
        }

        return $roles;
    }
}
