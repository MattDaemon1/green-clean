<?php

namespace App\Controller\Admin;

use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProjectsController extends AbstractController
{
    #[Route('/admin/projects', name: 'admin_projects')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $projects = $entityManager->getRepository(Projects::class)->findAll();

        return $this->render('admin/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/admin/projects/delete/{id}', name: 'admin_projects_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Projects::class)->find($id);

        if (!$project) {
            throw $this->createNotFoundException('The project does not exist');
        }

        $entityManager->remove($project);
        $entityManager->flush();

        $this->addFlash('success', 'Project deleted successfully.');

        return $this->redirectToRoute('admin_projects');
    }
}