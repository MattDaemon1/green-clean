<?php
namespace App\Service;

use App\Document\View;
use Doctrine\ODM\MongoDB\DocumentManager;

class ViewCountersService
{
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function incrementViewCount(int $projectId): int
    {
        $view = $this->documentManager->getRepository(View::class)->findOneBy(['projectId' => $projectId]);

        if (!$view) {
            $view = new View();
            $view->setProjectId($projectId);
            $this->documentManager->persist($view);
        }

        $view->incrementViewCount();
        $this->documentManager->flush();

        return $view->getViewCount();
    }
}