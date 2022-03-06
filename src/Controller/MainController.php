<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    
    #[Route('/', name: 'main_homepage')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    #[Route('/list', name: 'list_projects')]
    public function list(): Response
    {
        return $this->render('list.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}