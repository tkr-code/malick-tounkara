<?php

namespace App\Controller\Main;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EmailController
 * @Route("/email")
 */
class EmailController extends AbstractController
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    /**
     * @Route("/contact", name="email_contact")
     */
    public function contact(Request $request): Response
    {
        dd($request);
        $email = (new Email())
            ->from('contact@gmail.com')
            ->to('malick.tounkara.1@gmail.com')
            ->subject('Time for symfony')
            ->text('send email is fun againts')
            ->html('<p> malick tounkara</p>');
        $this->mailer->send($email);
        return new Response();
    }
}