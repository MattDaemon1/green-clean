<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DonationsRepository;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private $donationsRepository;

    public function __construct(DonationsRepository $donationsRepository)
    {
        $this->donationsRepository = $donationsRepository;
    }

    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('user/dashboard.html.twig');
    }

    /**
     * @Route("/user/profile", name="user_profile")
     */
    public function profile(): Response
    {
        // Logic for user profile
        return $this->render('user/profile.html.twig');
    }

    /**
     * @Route("/user/projects", name="user_projects")
     */
    public function projects(): Response
    {
        // Logic for user projects
        return $this->render('user/projects.html.twig');
    }

    /**
     * @Route("/user/donations", name="user_donations")
     */
    public function donations(Request $request): Response
    {
        $user = $this->getUser();
        $donations = $this->donationsRepository->findBy(['user' => $user]);

        return $this->render('user/donations.html.twig', [
            'donations' => $donations
        ]);
    }

    /**
     * @Route("/user/settings", name="user_settings")
     */
    public function settings(): Response
    {
        // Logic for user settings
        return $this->render('user/settings.html.twig');
    }
}