<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projets', name: 'app_projets')]
    public function index(ProjectsRepository $projectsRepository): Response
    {
        $projets = $projectsRepository->findBy([], ['id' => 'DESC']);

        

        return $this->render('projects/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/projects/{id}', name: 'app_projects_show')]
    public function show(Projects $projects): Response
    {
        dump($projects);
        return $this->render('projects/show.html.twig', [
            'projets' => $projects,
        ]);
    }
}
