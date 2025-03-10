namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class ProjectView
{
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="int")
     */
    private $projectId;

    /**
     * @MongoDB\Field(type="int")
     */
    private $viewCount = 0;

    // Getters and setters

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function setViewCount(int $viewCount): self
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    public function incrementViewCount(): self
    {
        $this->viewCount++;
        return $this;
    }
}
