<?php

namespace App\Controller;

use App\Entity\Donations;
use App\Entity\Projects;
use App\Form\DonationsType;
use App\Repository\DonationsRepository;
use App\Repository\ProjectsRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ViewCounterService;

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
    public function show(Projects $projects, Request $request, EntityManagerInterface $entityManager,
                        Security $security, DonationsRepository $donationsRepository,
                        SessionInterface $session, ViewCounterService $viewCounterService): Response
    {
      

        $session->set('previous_url', $request->getUri());
        $user = $security->getUser ();

        // Incrémentation du nombre de vues
        $view = $viewCounterService->incrementViewCount($projects->getId());

        $donations = $donationsRepository->findOneBy([
            'projects' => $projects,
            'user' => $user,
        ]);
        
        if (!$donations) {
            $donations = new Donations();
            $donations->setProjects($projects);
            $donations->setUser ($user);
            $donations->setDate(new \DateTime());
        }
        
        $form = $this->createForm(DonationsType::class, $donations);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($donations);
            $entityManager->flush();
        
            $this->addFlash('success', 'Votre don a bien été enregistré.');
        
            return $this->redirectToRoute('app_projets');
        }
        
        return $this->render('projects/show.html.twig', [
            'projets' => $projects,
            'form' => $form,
            'user' => $user,
            'views' => $view,
            
        ]);
    }

    #[Route('/projets/filtrer', name: 'app_projets_filter', methods: ['GET'])]
    public function filter(Request $request, ProjectsRepository $projectsRepository): Response
    {
        $keyword = $request->query->get('keyword');
        $updatedAfter = $request->query->get('updatedAfter') ? new \DateTimeImmutable($request->query->get('updatedAfter')) : null;
        $minDonations = $request->query->get('minDonations') ? (int) $request->query->get('minDonations') : null;

        $filteredProjects = $projectsRepository->filterProjects($keyword, $updatedAfter, $minDonations);

        return $this->render('projects/filter_results.html.twig', [
            'projets' => $filteredProjects,
        ]);
    }
}