<?php

namespace App\Repository;

use App\Entity\Projects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projects>
 */
class ProjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projects::class);
    }

    //    /**
    //     * @return Projects[] Returns an array of Projects objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Projects
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function filterProjects(?string $keyword, ?\DateTimeImmutable $updatedAfter, ?int $minDonations): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($keyword) {
            $qb->andWhere('p.title LIKE :keyword OR p.description LIKE :keyword')
               ->setParameter('keyword', '%' . $keyword . '%');
        }

        if ($updatedAfter) {
            $qb->andWhere('p.updatedAt >= :updatedAfter')
               ->setParameter('updatedAfter', $updatedAfter);
        }

        if ($minDonations !== null) {
            $qb->leftJoin('p.donations', 'd')
               ->groupBy('p.id')
               ->having('COUNT(d.id) >= :minDonations')
               ->setParameter('minDonations', $minDonations);
        }

        return $qb->getQuery()->getResult();
    }
}
