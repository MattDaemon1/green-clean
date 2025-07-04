<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Donations;
use Doctrine\ORM\EntityManagerInterface;

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
}