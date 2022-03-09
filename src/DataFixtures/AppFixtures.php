<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture 
{
    /** @var ObjectManager */
    private $manager;
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;


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

    }

}