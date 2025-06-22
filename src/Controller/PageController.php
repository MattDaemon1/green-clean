<?php

namespace App\Controller;

use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBagInterface): Response
    {
        $limit = $parameterBagInterface->get('home_projets_limit');
        $repository = $entityManager->getRepository(\App\Entity\Projects::class);
        $projets = $repository->findBy([], ['id' => 'DESC'], $limit);

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
