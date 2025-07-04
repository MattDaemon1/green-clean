<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $success = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Par exemple, envoyer un email :
            // $mailer->send(...);

            // Ou enregistrer le message en base de données :
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($data);
            // $entityManager->flush();
            $success = true;
        }

        return $this->render('page/contact.html.twig', [
            'form' => $form->createView(),
            'success' => $success,
        ]);
    }
}
