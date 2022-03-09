<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    
    #[Route('/', name: 'main_dashboard')]
    public function index(): Response
    {
        return $this->render('Dashboard/index.html.twig', [
            'controller_name' => 'MainController',
            'current_route' => 'main_dashboard'
        ]);
    }
        
}