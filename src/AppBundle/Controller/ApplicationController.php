<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Form\Type\ApplicationType;
use AppBundle\Voter\Actions\VoterActions;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/application")
 */
class ApplicationController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="application_index")
     */
    public function indexAction()
    {
        return $this->render('application/index.html.twig', [
            'applications' => $this->getUser()->getApplications()
        ]);
    }

    /**
     * @param Application $application
     * @return Response
     *
     * @Route("/{application}/view", name="application_view")
     */
    public function viewAction(Application $application)
    {
        return $this->render('application/view.html.twig', [
            'application' => $application,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/add", name="application_add")
     */
    public function addAction(Request $request)
    {
        $application = new Application;

        $form = $this->createForm(ApplicationType::class, $application);

        if ($form->handleRequest($request)->isValid()) {
            $this->persistAndFlush($application);

            $this->addSuccessFlash('application.added');

            return $this->redirectToRoute('application_index');
        }

        return $this->render('application/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Application $application
     * @param Request $request
     * @return Response
     *
     * @Route("/{application}/edit", name="application_edit")
     */
    public function editAction(Application $application, Request $request)
    {
        $this->denyAccessUnlessGranted(VoterActions::EDIT, $application);

        $form = $this->createForm(ApplicationType::class, $application);

        if ($form->handleRequest($request)->isValid()) {
            $this->flush();

            $this->addSuccessFlash('general.saved');

            return $this->redirectToRoute('application_index');
        }

        return $this->render('application/edit.html.twig', [
            'form' => $form->createView(),
            'application' => $application,
        ]);
    }

    /**
     * @param Application $application
     * @return Response
     *
     * @Route("/{application}/remove", name="application_remove")
     */
    public function removeAction(Application $application)
    {
        $this->denyAccessUnlessGranted(VoterActions::REMOVE, $application);

        $this->removeAndFlush($application);

        $this->addInfoFlash('application.removed');

        return $this->redirectToRoute('application_index');
    }
}