<?php

namespace App\Controller;

use App\Model\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function createFormulaire(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
    
        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                dump($form->getData());

                $this->addFlash('success', 'Votre message est bien envoyé');
                
                $email = (new Email())
                ->from('contact@monsite.com')
                ->to('contact@monsite.com')
                ->subject($contact->getName().'a fait une demande')
                ->html('<h1>Email: ' . $contact->getEmail() . '</h1>');
    
                $mailer->send($email);
                
               // return $this->redirectToRoute('contact');
            }

            return $this->render('contact/contact.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}