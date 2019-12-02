<?php

namespace App\Service\Email;

use App\Entity\Contact;
use Twig\Environment;

class EmailService 
{

  private $mailer;
  private $templating;

  public function __construct(\Swift_Mailer $mailer, Environment $templating)
  {
    $this->mailer = $mailer;
    $this->templating = $templating;
  }

  public function index(Contact $contact)
  {
    $message = (new \Swift_Message('Brulerie contact'))
  ->setFrom('noreply@brulerie.com')
  ->setTo('lionneclement@gmail.com')
  ->setBody(
    $this->templating->render(
        'Email/ContactForm.html.twig',
        ['contact' => $contact]
    ),'text/html')
  ->setReplyTo($contact->getEmail());
   $this->mailer->send($message);
  }
}
