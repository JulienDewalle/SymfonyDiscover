<?php

namespace App\Controller;

use App\Model\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function createFormulaire(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
    
        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                dump($form->getData());

                $this->addFlash('success', 'Votre message est bien envoyé');
                return $this->redirectToRoute('contact');

               /* $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                $mailer->send($message);
                dump($message); */
            }

            return $this->render('contact/contact.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}