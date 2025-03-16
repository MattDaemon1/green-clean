<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="project_views")
 */
class ProjectView
{
    /** @MongoDB\Id */
    private $id;

    /** @MongoDB\Field(type="string") */ // Changez en "string" si nécessaire
    private $projectId;

    /** @MongoDB\Field(type="int") */
    private $viewCount;

    public function __construct(string $projectId)
    {
        $this->projectId = $projectId;
        $this->viewCount = 0; // Initialisation dans le constructeur
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getProjectId(): string // Changez en "string" si nécessaire
    {
        return $this->projectId;
    }

    public function setProjectId(string $projectId): self // Changez en "string" si nécessaire
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function incrementViewCount(): self
    {
        $this->viewCount++;
        return $this;
    }
}