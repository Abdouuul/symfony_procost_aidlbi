<?php

namespace App\Controller;

use App\Entity\Worker;
use App\Form\WorkerType;
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
    }

    #[Route('/workers', name: 'list_workers')]
    public function listWorkers(): Response
    {
        return $this->render('Workers/list.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'list_workers'
        ]);
    }

    #[Route('/workers/edit/{id}', name: 'worker_show')]
    public function showWorker(int $id): Response
    {
        return $this->render('Workers/show.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'worker_show',
            'worker_id' => $id
        ]);
    }

    #[Route('/workers/new', name: 'worker_new')]
    public function newWorker(Request $request): Response
    {
        $worker = new Worker();
        $form = $this->createForm(WorkerType::class, $worker);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($worker);
            $this->em->flush();

            return $this->redirectToRoute('list_workers');
        }

        return $this->render('Workers/new.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'worker_new',
            'form' => $form->createView()

        ]);
    }


}