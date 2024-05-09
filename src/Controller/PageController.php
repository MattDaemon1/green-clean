<?php

namespace App\Controller;

use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProjectsRepository $projectsRepository): Response
    {

        $projets = $projectsRepository->findBy([], ['id' => 'DESC'],3);

        $websiteName = 'Green & Clean';
        return $this->render('page/index.html.twig', [
            'websiteName' => $websiteName,
            'projets' => $projets,
        ]);
    }

    #[Route('/projets', name: 'app_projets')]
    public function projets(): Response
    {
        $websiteName = 'Green & Clean';
        return $this->render('page/index.html.twig', [
            'websiteName' => $websiteName,
        ]);
    }
}
