<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $success = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            // Création et envoi de l'email
            $email = (new Email())
                ->from($data['email']) // Utilise l'email saisi dans le formulaire
                ->to('matt@mattkonnect.com') // Votre adresse de réception
                ->subject('Nouveau message de contact: ' . $data['subject'])
                ->text('Expéditeur: ' . $data['name'] . ' (' . $data['email'] . ")\n\n" . $data['message']);

            try {
                $mailer->send($email);
                $success = true;
            } catch (\Exception $e) {
                // Vous pourriez logger l'erreur ou afficher un message à l'utilisateur
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi du message : ' . $e->getMessage());
            }
        }

        return $this->render('page/contact.html.twig', [
            'form' => $form->createView(),
            'success' => $success,
        ]);
    }
}
