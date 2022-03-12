<?php
namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\WorkerRepository;
use App\Repository\WorkTimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    public function __construct(
        private ProjectRepository $projectRepository,
        private WorkTimeRepository $workTimeRepository,
        private WorkerRepository $workerRepository
    )
    {
        $this->projectRepository = $projectRepository;
        $this->workTimeRepository = $workTimeRepository;
        $this->workerRepository = $workerRepository;
    }

    
    #[Route('/', name: 'main_dashboard')]
    public function index(): Response
    {
        $latestCreatedProjects = $this->projectRepository->findLatestCreatedProjects();

        $latestWorkTimes = $this->workTimeRepository->findLatestTenWorkTimes();

        $deliveredProjects = $this->projectRepository->findCountOfDelieveredProjects();

        $onGoingProjects = $this->projectRepository->findCountOfOngoingProjects();

        $projectsCount = $this->projectRepository->findCountOfProjects();

        $workTimesCount = $this->workTimeRepository->findWorktimesCount();

        $workersCount = $this->workerRepository->findCountOfWorkers();

        $topWorker = $this->workerRepository->findTopWorker();



        $deliveredProjectsPercentage = $deliveredProjects / $projectsCount * 100 ;

        return $this->render('Dashboard/index.html.twig', [
            'controller_name' => 'MainController',
            'current_route' => 'main_dashboard',
            'latestCreatedProjects' => $latestCreatedProjects,
            'latestWorkTimes' => $latestWorkTimes,
            'deliveredProjects' => $deliveredProjects,
            'onGoingProjects' => $onGoingProjects,
            'projectsCount' => $projectsCount,
            'deliveredProjectsPercentage' => (int) $deliveredProjectsPercentage,
            'workTimesCount' => $workTimesCount,
            'workersCount' => $workersCount,
            'topWorker' => $topWorker,
        ]);
    }
        
}