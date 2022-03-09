<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkerController extends AbstractController
{
    #[Route('/workers', name: 'list_workers')]
    public function listWorkers(): Response
    {
        return $this->render('Workers/list.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'list_workers'
        ]);
    }

    #[Route('/workers/{id}', name: 'worker_show')]
    public function showWorker(int $id): Response
    {
        return $this->render('Workers/show.html.twig', [
            'controller_name' => 'WorkerController',
            'current_route' => 'worker_show',
            'worker_id' => $id
        ]);
    }
}