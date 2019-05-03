<?php

namespace App\Controller;

use App\DTO\PasswordDTO;
use App\Entity\User;
use App\Exception\EntityNotDeletedException;
use App\Form\PasswordForm;
use App\Form\UserForm;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/password/change", name="change_password")
     * @Security("is_granted('ROLE_USER')")
     */
    public function changePassword(Request $request)
    {
        $form = $this->createForm(PasswordForm::class, $psw = new PasswordDTO());

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->userService->changePassword($psw->getNewPassword());
            return $this->redirectToRoute('app_login');
        }

        return $this->render("security/change_password.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users", name="manage_users")
     * @Security("is_granted('ROLE_USER')")
     */
    public function showUsers()
    {
        $users = $this->userService->findAll();

        return $this->render('users/manage_users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/new", name="new_user")
     * @Security("is_granted('ROLE_USER')")
     */
    public function newUser(Request $request)
    {
        $form = $this->createForm(UserForm::class, $user = new User());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->newUser($user);
            return $this->redirectToRoute('manage_users');
        }

        return $this->render(
            'users/user_form.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
            ]);
    }

    /**
     * @Route("/users/edit/{id}", name="edit_user")
     * @Security("is_granted('ROLE_USER')")
     */
    public function editUser(Request $request, User $user)
    {
        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->editUser();
            return $this->redirectToRoute('manage_users');
        }

        return $this->render(
            'users/user_form.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
            ]);
    }

    /**
     * @Route("/users/delete/{id}", name="delete_user")
     * @Security("is_granted('ROLE_USER')")
     */
    public function deleteUser(Request $request, User $user)
    {
        try {
            $user = $this->userService->findById($user->getId());
            $this->userService->deleteUser($user);
        } catch (EntityNotDeletedException $exception) {
            $this->addFlash(
                'error',
                $exception->getMessage()
            );
        }
        return $this->redirectToRoute('manage_users');
    }
}
