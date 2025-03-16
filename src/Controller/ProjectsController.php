<?php

namespace App\Controller;

use App\Entity\Donations;
use App\Entity\Projects;
use App\Form\DonationsType;
use App\Repository\DonationsRepository;
use App\Repository\ProjectsRepository;
use App\Service\ProjectViewService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    private $projectViewService;

    // service de comptage dans le constructeur
    public function __construct(ProjectViewService $projectViewService)
    {
        $this->projectViewService = $projectViewService;
    }

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
                        SessionInterface $session): Response
    {
        // Incrémenter le compteur de vues
        $this->projectViewService->incrementView($projects->getId());

        // Récupérer le nombre de vues
        $viewCount = $this->projectViewService->getViewCount($projects->getId());

        $session->set('previous_url', $request->getUri());
        $user = $security->getUser ();

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
            'viewCount' => $viewCount, // Ajoutez le nombre de vues à la vue
        ]);
    }
}