<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class UsersController extends AbstractController
{
    public function __construct(private UserRepository $userRepository) {}

    #[Route('/admin/users', name: 'admin_users')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/users/{id}/edit', name: 'admin_users_edit', methods: ['GET', 'POST'])]
    public function edit(int $id): Response
    {
        // Logique pour modifier un utilisateur
        return $this->render('admin/users_edit.html.twig');
    }

    #[Route('/admin/users/{id}/delete', name: 'admin_users_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        // Logique pour supprimer un utilisateur
        return $this->redirectToRoute('admin_users');
    }

    #[Route('/admin/users/create', name: 'admin_users_create', methods: ['GET', 'POST'])]
    public function create(): Response
    {
        // Logique pour créer un utilisateur
        return $this->render('admin/users_create.html.twig');
    }
}