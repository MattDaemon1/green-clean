<?php

namespace App\Controller;

use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'app_projects')]
    public function index(ProjectsRepository $projectsRepository): Response
    {
        $projets = $projectsRepository->findBy([], ['id' => 'DESC']);

        

        return $this->render('projects/index.html.twig', [
            'projets' => $projets,
        ]);
    }
}
