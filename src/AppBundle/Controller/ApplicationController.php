<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Application;
use AppBundle\Enums\ApplicationTransition;
use AppBundle\Form\Type\ApplicationRejectionType;
use AppBundle\Form\Type\ApplicationType;
use AppBundle\Repository\ApplicationRepository;
use AppBundle\Service\Workflow\Application\ApplicationWorkflow;
use AppBundle\Voter\Actions\VoterActions;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    public function indexAction(): Response
    {
        return $this->render('application/index.html.twig', [
            'applications' => $this->getApplications()
        ]);
    }

    /**
     * @return Application[] | Collection
     */
    private function getApplications(): Collection
    {
        $user = $this->getUser();

        if ($user->isReviewer()) {
            return new ArrayCollection($this->getApplicationRepository()->findAllReviewableAndOfUser($user));
        }

        return $user->getApplications();
    }

    /**
     * @return ApplicationRepository
     */
    private function getApplicationRepository(): ApplicationRepository
    {
        return $this->get('app.repository.application');
    }

    /**
     * @param Application $application
     * @return Response
     *
     * @Route("/{application}/view", name="application_view")
     */
    public function viewAction(Application $application): Response
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
    public function addAction(Request $request): Response
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
    public function editAction(Application $application, Request $request): Response
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
     * @Route("/{application}/remove", name="application_remove", methods={"post"})
     */
    public function removeAction(Application $application): Response
    {
        $this->denyAccessUnlessGranted(VoterActions::REMOVE, $application);

        $this->removeAndFlush($application);

        $this->addInfoFlash('application.removed');

        return $this->redirectToRoute('application_index');
    }

    /**
     * @param Application $application
     * @return Response
     *
     * @Route("/{application}/submit", name="application_submit", methods={"post"})
     */
    public function submitAction(Application $application): Response
    {
        return $this->changeState($application, ApplicationTransition::SUBMIT(), 'application.submitted');
    }

    /**
     * @param Application $application
     * @return Response
     *
     * @Route("/{application}/accept", name="application_accept", methods={"post"})
     */
    public function acceptAction(Application $application): Response
    {
        return $this->changeState($application, ApplicationTransition::ACCEPT(), 'application.accepted');
    }

    /**
     * @param Application $application
     * @param Request     $request
     * @return Response
     *
     * @Route("/{application}/reject", name="application_reject")
     */
    public function rejectAction(Application $application, Request $request): Response
    {
        $this->denyAccessUnlessGranted(ApplicationTransition::REJECT, $application);

        $form = $this->createForm(ApplicationRejectionType::class, $application);

        if ($form->handleRequest($request)->isValid()) {
            return $this->changeState($application, ApplicationTransition::REJECT(), 'application.rejected');
        }

        return $this->render('application/reject.html.twig', [
            'form' => $form->createView(),
            'application' => $application,
        ]);
    }

    /**
     * @param Application           $application
     * @param ApplicationTransition $transition
     * @param string                $message
     * @return Response
     */
    private function changeState(Application $application, ApplicationTransition $transition, string $message): Response
    {
        $this->denyAccessUnlessGranted((string) $transition, $application);

        $this->getApplicationWorkflow()->apply($application, (string) $transition);

        $this->persistAndFlush($application);

        $this->addInfoFlash($message);

        return $this->redirectToRoute('application_view', [
            'application' => $application->getId()
        ]);
    }

    /**
     * @param Application $application
     * @return Response
     */
    private function redirectToView(Application $application): Response
    {
        return $this->redirectToRoute('application_view', [
            'application' => $application->getId(),
        ]);
    }

    /**
     * @return ApplicationWorkflow
     */
    private function getApplicationWorkflow(): ApplicationWorkflow
    {
        return $this->get('state_machine.application');
    }
}
