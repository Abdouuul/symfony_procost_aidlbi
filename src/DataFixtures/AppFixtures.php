<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\Project;
use App\Entity\Worker;
use App\Entity\WorkTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture 
{
    private const DATA_JOBS = [
        ['Web designer'],
        ['SEO Manager'],
        ['Web Developer'],
        ['Data Analyist'],
        ['Développeur Symfony'],
        ['Game Dev C++'],
        ['Database manager'],
        ['Marketing expert'],
        ['C# Dev'],
        ['PHP Dev'],
        ['Graphic Designer'],
        ['React Dev']
    ];
    
    private const DATA_WORKERS = [];
    private const DATA_PROJECTS = [];

    /** @var ObjectManager */
    private $manager;
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadJobs();
        $this->loadProjects();
        $this->loadWorkers();
        // $this->loadWorkTimes();
        $manager->flush();
    }

    private function loadJobs(): void
    {
        foreach (self::DATA_JOBS as $key => [$jobname]) {
            $job = new Job();
            $job->setName($jobname);
            $this->manager->persist($job);
            $this->addReference(Job::class . $key, $job);
        }
    }

    private function loadWorkers(): void
    {
        for ($i=0; $i < 20; $i++) { 
            $worker = new Worker();
            $worker->setFirstName('worker-firstName-' . $i)
                    ->setLastName('worker-lastName')
                    ->setEmail('worker-email-' . $i . '@gmail.com')
                    ->setDailycost(rand(200, 1000))
                    ->setEmployedAt(new \DateTime())
                    ->setJob($this->getRandomEntityReference(Job::class, self::DATA_JOBS));
            ;
            $this->addReference(Worker::class . $i, $worker);
            $this->manager->persist($worker);
        }
    }

    private function loadProjects(): void
    {
        for ($i=0; $i < 20; $i++) { 
            $project = new Project();
            $project->setName('project-name-' . $i)
                    ->setDescription('project-description-' . $i)
                    ->setPrice(random_int(4000,12000))
                    ->setDeliveryDate(new \DateTime())
                    ->setCreatedAt(new \DateTime())
            ;
            $this->addReference(Project::class . $i, $project);
            $this->manager->persist($project);
        }
    }

    private function loadworktimes(): void
    {
        for ($i=0; $i < 20; $i++) { 
            $worktime = new WorkTime();
            $project = $this->getReference(Project::class . (string) random_int(0,19));
            $worker = $this->getReference(Worker::class . (string) random_int(0,19));

            $worktime->setProject($this->getReference($project))
                    ->setWorker($this->getReference($worker))
                    ->setDays(random_int(1, 10))
                    ->setCost($worker->getDailycost() * $worktime->getDays())
            ;
            $this->manager->persist($worktime);
        }
    }

    /**
     * @param class-string $entityClass
     * 
     * @return object<class-string>
     */
    private function getRandomEntityReference(string $entityClass, array $data): object {
        return $this->getReference($entityClass . random_int(0, count($data) - 1));
    }
}