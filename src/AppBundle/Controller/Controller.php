<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * @method User getUser
 */
class Controller extends BaseController
{
    /**
     * @param string $message
     */
    protected function addInfoFlash(string $message): void
    {
        $this->addFlash('primary', $message);
    }

    /**
     * @param string $message
     */
    protected function addSuccessFlash(string $message): void
    {
        $this->addFlash('success', $message);
    }

    /**
     * @param string $message
     */
    protected function addWarningFlash(string $message): void
    {
        $this->addFlash('warning', $message);
    }

    /**
     * @param string $message
     */
    protected function addErrorFlash(string $message): void
    {
        $this->addFlash('alert', $message);
    }

    /**
     * @param mixed $entity
     */
    protected function persistAndFlush($entity): void
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * @param mixed $entity
     */
    protected function removeAndFlush($entity): void
    {
        $this->remove($entity);
        $this->flush();
    }

    /**
     * @param mixed $entity
     */
    protected function persist($entity): void
    {
        $this->getManager()->persist($entity);
    }

    /**
     * @param mixed $entity
     */
    protected function remove($entity): void
    {
        $this->getManager()->remove($entity);
    }

    /**
     * @return void
     */
    protected function flush(): void
    {
        $this->getManager()->flush();
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getManager(): EntityManagerInterface
    {
        return $this->getDoctrine()->getManager();
    }
}
