<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectStatsRepository;
use App\Service\ViewCounterService;

class DashboardController extends AbstractController
{
    public function __construct(
        private ViewCounterService $viewCounterService
    ) {
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function index(ProjectStatsRepository $projectStatsRepository): Response
    {
        $projects = $projectStatsRepository->getProjectsByViews();
        
        $stats = [];
        foreach ($projects as $project) {
            $stats[] = [
                'project' => $project,
                'views' => $this->viewCounterService->getViewCount($project->getId())
            ];
        }

        return $this->render('admin/dashboard.html.twig', [
            'topProjects' => $stats
        ]);
    }
}
