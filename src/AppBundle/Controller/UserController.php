<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Repository\UserRepository;
use AppBundle\Voter\Actions\VoterActions;
use Doctrine\Common\Persistence\ObjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
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
    public function indexAction(): Response
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
    public function viewAction(User $user): Response
    {
        $this->denyAccessUnlessGranted(VoterActions::VIEW, $user);

        return $this->render('user/view.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     *
     * @Route("/{user}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted(VoterActions::EDIT, $user);

        $form = $this->createEditForm($user);

        if ($form->handleRequest($request)->isValid()) {
            $this->flush();

            $this->addSuccessFlash('general.saved');

            return $this->redirectToView($user);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @param User $user
     * @return FormInterface
     */
    private function createEditForm(User $user): FormInterface
    {
        return $this->createForm(UserType::class, $user, [
            'require_password' => !$this->getUser()->isSuperAdmin()
        ]);
    }

    /**
     * @param User $user
     * @return Response
     *
     * @Route("/{user}/remove", name="user_remove")
     */
    public function removeAction(User $user): Response
    {
        $this->denyAccessUnlessGranted(VoterActions::REMOVE, $user);

        $this->removeAndFlush($user);

        $this->addInfoFlash('user.removed');

        return $this->redirectToRoute('user_index');
    }

    /**
     * @return UserRepository
     */
    private function getUserRepository(): UserRepository
    {
        return $this->getManager()->getRepository(User::class);
    }

    /**
     * @param User $user
     * @return Response
     */
    private function redirectToView(User $user): Response
    {
        return $this->redirectToRoute('user_view', [
            'user' => $user->getId(),
        ]);
    }
}
