<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 * @Security("has_role('ROLE_ADMIN')")
 */
class UserController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="user_index")
     */
    public function indexAction()
    {
    }
}