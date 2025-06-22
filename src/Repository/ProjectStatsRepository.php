<?php

namespace App\Repository;

use App\Entity\Projects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\ViewCounterService;

class ProjectStatsRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private ViewCounterService $viewCounterService
    ) {
        parent::__construct($registry, Projects::class);
    }

    public function getProjectsByViews(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}

