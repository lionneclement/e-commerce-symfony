<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Contact;
use App\Service\Email\EmailService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     */
    public function index(Request $request, EmailService $emailService)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $emailService->index($contact);
          $this->addFlash('success','Votre email a bien été envoyé');
          return $this->redirectToRoute('contact_index', [
            'form' => $form->createView(),
        ]);
        }

        return $this->render('Contact/index.html.twig', [
          'form' => $form->createView(),
      ]);
    }
}