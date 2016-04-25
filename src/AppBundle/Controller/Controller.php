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
     * @return EntityManagerInterface
     */
    public function getManager()
    {
        return $this->getDoctrine()->getManager();
    }
}