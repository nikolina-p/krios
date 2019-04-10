<?php

namespace App\Controller;

use App\DTO\PasswordDTO;
use App\Form\PasswordForm;
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
}
