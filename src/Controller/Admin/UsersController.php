<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_users')]
    public function index(): Response
    {
        return $this->render('admin/users.html.twig');
    }
}