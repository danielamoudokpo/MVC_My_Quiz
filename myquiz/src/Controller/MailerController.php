<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    
    // public function sendEmail(MailerInterface $mailer)
    // {
    //     $email = (new Email())
    //         ->from('hello@example.com')
    //         ->to('pablofiacro99@gmail.com')
    //         //->cc('cc@example.com')
    //         //->bcc('bcc@example.com')
    //         //->replyTo('fabien@example.com')
    //         //->priority(Email::PRIORITY_HIGH)
    //         ->subject('Time for Symfony Mailer!')
    //         ->text('Sending emails is fun again!')
    //         ->html('<p>See Twig integration for better HTML integration!</p>');

    //     $mailer->send($email);

    //     // ...
    // }
}
