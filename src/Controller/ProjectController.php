<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProjectRepository $projectRepository
        )
    {
        $this->em = $em;
        $this->projectRepository = $projectRepository;
    }
    #[Route('/projects', name: 'list_projects')]
    public function listProjects(): Response
    {
        $projects = $this->projectRepository->findAll();

        return $this->render('Projects/list.html.twig', [
            'controller_name' => 'ProjectController',
            'current_route' => 'list_projects',
            'projects' => $projects
        ]);
    }


    #[Route('/projects/new', name: 'project_new')]
    public function newProject(Request $request): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('list_projects');
        }
        
        return $this->render('Projects/form.html.twig', [
            'controller_name' => 'ProjectController',
            'current_route' => 'project_new',
            'form' => $form->createView()
        ]);
    }


    #[Route('/projects/view/{id}', name: 'project_show')]
    public function showProject(int $id): Response
    {
        $project = $this->projectRepository->findOneWithDetails($id);
        
        return $this->render('Projects/detail.html.twig', [
            'controller_name' => 'ProjectController',
            'current_route' => 'project_show',
            'project' => $project
        ]);
    }

    #[Route('/projects/edit/{id}', name: 'project_edit')]
    public function editProject(int $id, Request $request): Response
    {
        $project = $this->projectRepository->findOneWithDetails($id);
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('list_projects');
        }
        
        return $this->render('Projects/form.html.twig', [
            'controller_name' => 'ProjectController',
            'current_route' => 'project_new',
            'form' => $form->createView()
        ]);
    }
}