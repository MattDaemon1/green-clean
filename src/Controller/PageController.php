<?php

namespace App\Controller;

use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProjectsRepository $projectsRepository, ParameterBagInterface $parameterBagInterface): Response
    {

        $limit = $parameterBagInterface->get('home_projets_limit');
        $projets = $projectsRepository->findBy([], ['id' => 'DESC'],$limit);

        $websiteName = 'Green & Clean';
        return $this->render('page/index.html.twig', [
            'websiteName' => $websiteName,
            'projets' => $projets,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function projets(): Response
    {
        $websiteName = 'Green & Clean';
        return $this->render('page/about.html.twig', [
            'websiteName' => $websiteName,
        ]);
    }
}
