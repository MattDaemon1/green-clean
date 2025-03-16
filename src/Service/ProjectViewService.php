<?php

namespace App\Service;

use App\Document\ProjectView;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProjectViewService
{
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function incrementView(string $projectId)
    {
        $projectView = $this->documentManager->getRepository(ProjectView::class)->findOneBy(['projectId' => $projectId]);

        if (!$projectView) {
            $projectView = new ProjectView($projectId);
        }

        $projectView->incrementViewCount();
        $this->documentManager->persist($projectView);
        $this->documentManager->flush();
    }

    public function getViewCount(string $projectId): int
    {
        $projectView = $this->documentManager->getRepository(ProjectView::class)->findOneBy(['projectId' => $projectId]);
        return $projectView ? $projectView->getViewCount() : 0;
    }
}