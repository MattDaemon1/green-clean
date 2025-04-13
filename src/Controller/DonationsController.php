<?php

namespace App\Controller;

use App\Entity\Donations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonationsController extends AbstractController
{
    #[Route('/admin/donations', name: 'admin_donations')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $donations = $entityManager->getRepository(Donations::class)->findAll();

        return $this->render('admin/donations.html.twig', [
            'donations' => $donations,
        ]);
    }

    #[Route('/admin/donations/create', name: 'admin_donations_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        // Logic for creating a new donation (form handling, etc.)
        return $this->render('admin/donations_form.html.twig');
    }

    #[Route('/admin/donations/edit/{id}', name: 'admin_donations_edit')]
    public function edit(int $id, EntityManagerInterface $entityManager): Response
    {
        $donation = $entityManager->getRepository(Donations::class)->find($id);

        if (!$donation) {
            throw $this->createNotFoundException('Donation not found');
        }

        // Logic for editing the donation (form handling, etc.)
        return $this->render('admin/donations_form.html.twig', [
            'donation' => $donation,
        ]);
    }

    #[Route('/admin/donations/delete/{id}', name: 'admin_donations_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $donation = $entityManager->getRepository(Donations::class)->find($id);

        if ($donation) {
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_donations');
    }
}