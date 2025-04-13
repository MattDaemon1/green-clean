<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectsController extends AbstractController
{
    #[Route('/admin/projects', name: 'admin_projects')]
    public function index(): Response
    {
        return $this->render('admin/projects.html.twig');
    }
}