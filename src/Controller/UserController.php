<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Attributes\RouteAttributes;
use App\Repository\DonationsRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    private $donationsRepository;
    private $entityManager;

    public function __construct(DonationsRepository $donationsRepository, EntityManagerInterface $entityManager)
    {
        $this->donationsRepository = $donationsRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/user/dashboard', name: 'user_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('user/dashboard.html.twig');
    }

    #[Route('/user/profile', name: 'user_profile')]
    public function profile(): Response
    {
        // Logic for user profile
        return $this->render('user/profile.html.twig');
    }

    #[Route('/user/{id}/edit', name: 'user_user_edit')]
    public function user_edit(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            
            // Hash the password if it was changed
            if ($form->get('plainPassword')->getData()) {
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            $this->entityManager->flush();
            
            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/profile-edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/user/projects', name: 'user_projects')]
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

    /**
     * @Route("/user/profile/update", name="user_profile_update", methods={"POST"})
     */
    public function updateProfile(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre profil.');
        }

        $email = $request->request->get('email');
        $nickname = $request->request->get('nickname');
        $password = $request->request->get('password');
        $passwordConfirm = $request->request->get('password_confirm');

        if ($password && $password !== $passwordConfirm) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            return $this->redirectToRoute('user_profile');
        }

        $user->setEmail($email);
        $user->setNickname($nickname);

        if ($password) {
            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

        return $this->redirectToRoute('user_profile');
    }
    
            $this->addFlash('error', 'Une erreur est survenue lors de la mise à jour de votre profil.');
            return $this->redirectToRoute('user_profile');
        }
    }