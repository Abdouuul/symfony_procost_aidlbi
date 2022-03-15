<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;

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
    public function listProjects(Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $projects = $this->projectRepository->findAll();

        $projects = $paginatorInterface->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

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
    public function showProject(int $id, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $project = $this->projectRepository->findOneWithDetails($id);

        if ($project === null) {
            throw new NotFoundHttpException();
        }

        $worktimes = $project->getWorktimes();
        $worktimes = $paginatorInterface->paginate(
            $worktimes, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        $projectTotalCost = $this->projectRepository->findTotalCostOfOneProject($id);
        $projectWorkersCount = $this->projectRepository->findCountWorkerOfOneProject($id);

        return $this->render('Projects/detail.html.twig', [
            'controller_name' => 'ProjectController',
            'current_route' => 'project_show',
            'project' => $project,
            'worktimes' => $worktimes,
            'projectTotalCost' => $projectTotalCost,
            'projectWorkersCount' => $projectWorkersCount

        ]);
    }

    #[Route('/projects/edit/{id}', name: 'project_edit')]
    public function editProject(int $id, Request $request): Response
    {
        $project = $this->projectRepository->findOneWithDetails($id);
        if ($project === null || $project->getDeliveryDate() !== null) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('list_projects');
        }
        
        return $this->render('Projects/form.html.twig', [
            'controller_name' => 'ProjectController',
            'current_route' => 'project_edit',
            'form' => $form->createView()
        ]);
    }

    #[Route('/projects/deliver/{id}', name: 'project_delivered')]
    public function deliverProject(int $id): Response
    {
        $project = $this->projectRepository->findOneWithDetails($id);
        if ($project === null || $project->getDeliveryDate() !== null) {
            throw new NotFoundHttpException();
        }
        $project->setDeliveryDate(new \DateTime());
        $this->em->flush();

        return $this->redirectToRoute('list_projects');
    }

    #[Route('/projects/delete/{id}', name: 'project_delete')]
    public function deleteProject(int $id): Response
    {
        $project = $this->projectRepository->findOneWithDetails($id);
        if ($project === null || $project->getDeliveryDate() !== null) {
            throw new NotFoundHttpException();
        }
        
        if($project->getDeliveryDate() != null) {
            $this->em->remove($project);
            $this->em->flush();
        }
        

        return $this->redirectToRoute('list_projects');
    }
}