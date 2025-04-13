<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonationsController extends AbstractController
{
    #[Route('/admin/donations', name: 'admin_donations')]
    public function index(): Response
    {
        return $this->render('admin/donations.html.twig');
    }
}