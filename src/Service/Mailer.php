<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    private MailerInterface $mailer;
    private string $from;

    public function __construct(MailerInterface $mailer, string $from)
    {
        $this->mailer = $mailer;
        $this->from = $from;
    }

    /**
     * <p>This method will send a dummy email.</p>
     * <p>If everything went right, it returns true. Otherwise, it will return false.</p>
     *
     * @param string $to            the destination email address
     * @param string $emailSubject  the email's subject
     *
     * @return bool True when everything went ok. False otherwise
     */
    public function sendConfirmationMail(string $to, string $emailSubject): bool
    {
        try {
            $email = (new TemplatedEmail())
                ->from($this->from)
                ->to($to)
                ->subject($emailSubject)
                ->htmlTemplate('emails/signup.html.twig')
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => 'test',
                ]);
            $this->mailer->send($email);

            return true;
        } catch (TransportExceptionInterface) {
            return false;
        }
    }
}