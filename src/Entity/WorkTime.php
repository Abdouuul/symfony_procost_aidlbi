<?php


namespace App\Entity;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)\
 * @ORM\Table(name="app_worktimes")
 */

class WorkTime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="worktimes")
     * @ORM\JoinColumn(nullable=false, name="app_worktime_project_id")
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity=Worker::class, inversedBy="worktimes")
     * @ORM\JoinColumn(nullable=false, name="app_worktime_worker_id")
     */
    private $worker;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cost;

    /**
     * @ORM\Column(type="integer")
     */
    private $days;

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of project
     */ 
    public function getProject(): ?Project
    {
        return $this->project;
    }

    /**
     * Set the value of project
     *
     * @return  self
     */ 
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get the value of worker
     */ 
    public function getWorker(): ?Worker
    {
        return $this->worker;
    }

    /**
     * Set the value of worker
     *
     * @return  self
     */ 
    public function setWorker(Worker $worker)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get the value of cost
     */ 
    public function getCost(): ?string
    {
        return $this->cost;
    }

    /**
     * Set the value of cost
     *
     * @return  self
     */ 
    public function setCost(string $cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get the value of days
     */ 
    public function getDays(): ?int
    {
        return $this->days;
    }

    /**
     * Set the value of days
     *
     * @return  self
     */ 
    public function setDays(int $days)
    {
        $this->days = $days;

        return $this;
    }
}