<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Entity\WorkTime;
use App\Form\WorkerType;
use App\Form\WorkTimeType;
use App\Repository\WorkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkerController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private WorkerRepository $workerRepository
        )
    {
        $this->em = $em;
        $this->workerRepository = $workerRepository;
    }

    #[Route('/workers', name: 'list_workers')]
    public function listWorkers(): Response
    {
        $workers = $this->workerRepository->findAllWithDetails();

        return $this->render('Workers/list.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'list_workers',
            'workers' => $workers
        ]);
    }

    #[Route('/workers/view/{id}', name: 'worker_show')]
    public function showWorker(int $id, Request $request): Response
    {
        $worker = $this->workerRepository->findOneWithDetails($id);

        $worktime = new WorkTime();
        $form = $this->createForm(WorkTimeType::class, $worktime);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $worktime->setWorker($worker);

            $cost = (float) $worker->getDailycost() * $worktime->getDays();
            $worktime->setCost($cost);

            $this->em->persist($worktime);
            $this->em->flush();

            return $this->redirectToRoute('worker_show', ['id' => $worker->getId()]);
        }


        return $this->render('Workers/detail.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'worker_show',
            'worker' => $worker,
            'form' => $form->createView()
        ]);
    }

    #[Route('/workers/edit/{id}', name: 'worker_edit')]
    public function editWorker(int $id, Request $request): Response
    {
        $worker = $this->workerRepository->findOneWithDetails($id);
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($worker);
            $this->em->flush();

        }

        return $this->render('Workers/form.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'worker_new',
            'form' => $form->createView()

        ]);

    }

    #[Route('/workers/new', name: 'worker_new')]
    public function newWorker(Request $request): Response
    {
        $worker = new Worker();
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('list_workers');
        }

        return $this->render('Workers/form.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'worker_new',
            'form' => $form->createView()

        ]);
    }


}