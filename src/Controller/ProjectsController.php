<?php

namespace App\Controller;

use App\Entity\Donations;
use App\Entity\Projects;
use App\Form\DonationsType;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projets', name: 'app_projets')]
    public function index(ProjectsRepository $projectsRepository): Response
    {
        $projets = $projectsRepository->findBy([], ['id' => 'DESC']);

        

        return $this->render('projects/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/projects/{id}', name: 'app_projects_show')]
    public function show(Projects $projects, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();
        $donations = new Donations();
        $donations->setProjects($projects);
        $donations->setUser($user);
        

        $form = $this->createForm(DonationsType::class, $donations);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($donations);
            $entityManager->flush();
            

        }

        return $this->render('projects/show.html.twig', [
            'projets' => $projects,
            'form' => $form,
        ]);
    }
}
