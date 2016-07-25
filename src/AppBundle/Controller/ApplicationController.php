<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Form\Type\ApplicationType;
use AppBundle\Repository\ApplicationRepository;
use AppBundle\Voter\Actions\VoterActions;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
            'applications' => $this->getApplications()
        ]);
    }

    /**
     * @return Application[]|Collection
     */
    private function getApplications()
    {
        $user = $this->getUser();

        if ($user->isReviewer()) {
            return $this->getApplicationRepository()->findAllReviewable();
        }

        return $user->getApplications();
    }

    /**
     * @return ApplicationRepository
     */
    private function getApplicationRepository()
    {
        return $this->get('app.repository.application');
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

            return $this->redirectToView($application);

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

            return $this->redirectToView($application);
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

    /**
     * @param Application $application
     * @return RedirectResponse
     */
    private function redirectToView(Application $application)
    {
        return $this->redirectToRoute('application_view', [
            'application' => $application->getId(),
        ]);
    }
}