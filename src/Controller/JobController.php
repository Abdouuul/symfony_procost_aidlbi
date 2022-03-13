<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private JobRepository $jobRepository
        )
    {
        $this->em = $em;
        $this->jobRepository = $jobRepository;
    }
    #[Route('/jobs', name: 'list_jobs')]
    public function listWorkers(): Response
    {
        $jobs = $this->jobRepository->findAllWithDetails();
        return $this->render('Jobs/list.html.twig', [
            'controller_name' => 'JobController',
            'current_route' => 'list_jobs',
            'jobs' => $jobs
        ]);
    }

    #[Route('/jobs/new', name: 'new_jobs')]
    public function newJob(Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($job);
            $this->em->flush();
            return $this->redirectToRoute('list_jobs');
        }

        return $this->render('Jobs/form.html.twig', [
            'controller_name' => 'JobController',
            'current_route' => 'new_jobs',
            'form' => $form->createView()
        ]);
    }

    #[Route('/jobs/edit/{id}', name: 'jobs_edit')]
    public function editJob(int $id, Request $request): Response
    {
        $job = $this->jobRepository->find($id);
        if ($job === null) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('list_jobs');
        }

        return $this->render('Jobs/form.html.twig', [
            'controller_name' => 'JobController',
            'current_route' => 'jobs_edit',
            'form' => $form->createView()
        ]);
    }

    #[Route('/jobs/view/{id}', name: 'show_job')]
    public function showJob(int $id): Response
    {
        $job = $this->jobRepository->findOneWithDetails($id);

        if ($job === null) {
            throw new NotFoundHttpException();
        }
        return $this->render('Jobs/detail.html.twig', [
            'controller_name' => 'JobController',
            'current_route' => 'show_job',
            'job' => $job
        ]);
    }

    #[Route('/jobs/delete/{id}', name: 'delete_job')]
    public function deleteJob(int $id): Response
    {
        $job = $this->jobRepository->findOneWithDetails($id);
        if ($job === null || count($job->getWorkers()) > 0 ) {
            throw new NotFoundHttpException();
        }
        if($job->getWorkers()->count() === 0) {
            $this->em->remove($job);
            $this->em->flush();
        }
        return $this->redirectToRoute('list_jobs');
    }


}