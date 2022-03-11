<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture 
{
    private const DATA_JOBS = [
        ['Web designer'],
        ['SEO Manager'],
        ['Web Developer'],
        ['Data Analyist'],
    ];

    /** @var ObjectManager */
    private $manager;
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadJobs();
        $manager->flush();
    }


    private function loadWorkers(): void
    {

    }

    private function loadProjects(): void
    {

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

}