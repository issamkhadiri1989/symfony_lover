<?php

namespace App\Controller;

use App\Entity\Model\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route(path: "/new", name: "app_new_user")]
    public function newUser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        if ($form->isSubmitted() && $form->isValid()) {
            // persist here to database for example.
        }

        return $this->renderForm('user/new.html.twig', ['form' => $form]);
    }
}