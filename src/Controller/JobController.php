<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route('/jobs', name: 'list_jobs')]
    public function listWorkers(): Response
    {
        return $this->render('Jobs/list.html.twig', [
            'controller_name' => 'JobController',
            'current_route' => 'list_jobs'
        ]);
    }
}