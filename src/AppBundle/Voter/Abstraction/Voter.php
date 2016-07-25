<?php
namespace AppBundle\Voter\Abstraction;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter as BaseVoter;

abstract class Voter extends BaseVoter
{
    /**
     * @return string[]
     */
    abstract protected function getSupportedTypes();

    /**
     * @return string[]
     */
    abstract protected function getSupportedAttributes();

    /**
     * @param string         $checkedRole
     * @param TokenInterface $token
     * @return bool
     */
    protected function userHasRole($checkedRole, TokenInterface $token)
    {
        $roles = $token->getRoles();

        foreach ($roles as $role) {
            if ($role->getRole() === $checkedRole) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, $this->getSupportedAttributes())) {
            return false;
        }

        if (!$this->isSubjectSupported($subject)) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $subject
     * @return bool
     */
    private function isSubjectSupported($subject)
    {
        return in_array($this->getType($subject), $this->getSupportedTypes());
    }

    /**
     * @param mixed $subject
     * @return string
     */
    private function getType($subject)
    {
        if (is_object($subject)) {
            return get_class($subject);
        } else {
            return gettype($subject);
        }
    }
}