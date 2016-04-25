<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/application")
 */
class ApplicationController extends Controller
{
    /**
     * @Route("/", name="application_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('application/index.html.twig', [
            'applications' => $this->getUser()->getApplications()
        ]);
    }
}