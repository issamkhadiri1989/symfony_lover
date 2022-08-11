<?php

namespace App\Controller;

use App\Service\Mailer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class MailerController
{
    private Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route(path: "/example-mail", name: "app_send_mail")]
    public function notification(): Response
    {
        $this->mailer->sendConfirmationMail(
            to: 'Issam KHADIRI <khadiri.issam@gmail.com>',
            emailSubject: 'ipsum lorem dolore'
        );

        return new Response('A mail has been sent !');
    }
}