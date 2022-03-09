<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/projects', name: 'list_projects')]
    public function listProjects(): Response
    {
        return $this->render('Projects/list.html.twig', [
            'controller_name' => 'ProjectController',
            'current_route' => 'list_projects'
        ]);
    }
}