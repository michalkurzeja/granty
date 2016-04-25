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
    protected function addInfoFlash($message)
    {
        $this->addFlash('primary', $message);
    }

    /**
     * @param string $message
     */
    protected function addSuccessFlash($message)
    {
        $this->addFlash('success', $message);
    }

    /**
     * @param string $message
     */
    protected function addWarningFlash($message)
    {
        $this->addFlash('warning', $message);
    }

    /**
     * @param string $message
     */
    protected function addErrorFlash($message)
    {
        $this->addFlash('alert', $message);
    }

    /**
     * @param $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * @param $entity
     */
    protected function persist($entity)
    {
        $this->getManager()->persist($entity);
    }

    protected function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getManager()
    {
        return $this->getDoctrine()->getManager();
    }
}