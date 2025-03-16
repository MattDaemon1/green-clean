<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProjectViewService;
use MongoDB\Client;

/**
 * @Route("/projects")
 */
class ProjectViewController extends AbstractController
{
    private $projectViewService;

    public function __construct(ProjectViewService $projectViewService)
    {
        $this->projectViewService = $projectViewService;
    }

    /**
     * @Route("/{id}/view-count", name="projects_view_count", methods={"GET"})
     */
    public function viewCount(int $id): JsonResponse
    {
        $viewCount = $this->projectViewService->getViewCount($id);
        return new JsonResponse(['viewCount' => $viewCount]);
    }

    /**
     * @Route("/{id}/increment-view", name="projects_increment_view", methods={"POST"})
     */
    public function incrementView(int $id): JsonResponse
    {
        $this->projectViewService->incrementViewCount($id);
        return new JsonResponse(['message' => 'View count incremented']);
    }

}

/**
 * @Route("/mongo-test")
 */
class MongoTestController extends AbstractController
{
    /**
     * @Route("/check", name="mongo_check", methods={"GET"})
     */
    public function checkMongo(): JsonResponse
    {
        try {
            $client = new Client("mongodb://127.0.0.1:27017");
            $database = $client->selectDatabase("green_clean");

            return new JsonResponse([
                'message' => 'Connexion réussie à MongoDB !',
                'database' => $database->getDatabaseName()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Erreur de connexion à MongoDB',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
