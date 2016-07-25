<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Voter\Actions\VoterActions;
use Doctrine\Common\Persistence\ObjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
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
        return $this->render('user/index.html.twig', [
            'users' => $this->getUserRepository()->findAllExcept($this->getUser())
        ]);
    }

    /**
     * @param User $user
     * @return Response
     *
     * @Route("/{user}/view", name="user_view")
     */
    public function viewAction(User $user)
    {
        $this->denyAccessUnlessGranted(VoterActions::VIEW, $user);

        return $this->render('user/view.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/add", name="user_add")
     */
    public function addAction(Request $request)
    {
        $application = new User;

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
     * @param User $user
     * @param Request $request
     * @return Response
     *
     * @Route("/{user}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request)
    {
        $this->denyAccessUnlessGranted(VoterActions::EDIT, $user);

        $form = $this->createForm(ApplicationType::class, $user);

        if ($form->handleRequest($request)->isValid()) {
            $this->flush();

            $this->addSuccessFlash('general.saved');

            return $this->redirectToView($user);
        }

        return $this->render('application/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @param User $user
     * @return Response
     *
     * @Route("/{user}/remove", name="user_remove")
     */
    public function removeAction(User $user)
    {
        $this->denyAccessUnlessGranted(VoterActions::REMOVE, $user);

        $this->removeAndFlush($user);

        $this->addInfoFlash('user.removed');

        return $this->redirectToRoute('user_index');
    }

    /**
     * @return UserRepository | ObjectRepository
     */
    private function getUserRepository()
    {
        return $this->getManager()->getRepository(User::class);
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    private function redirectToView(User $user)
    {
        return $this->redirectToRoute('user_view', [
            'user' => $user->getId(),
        ]);
    }
}