<?php 

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)\
 * @ORM\Table(name="app_workers")
 */
class Worker{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le nom complet.")
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner l'email.")
     * @Assert\Email(message="L'email {{ value }} n'est pas valide.")
     */
    private $email;

    // /**
    //  * to determine
    //  */
    // private $job;

    // /**
    //  * To determine
    //  */
    // private $projects;

    /**
     * @ORM\Column(type="float", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le coût journalier.")
     */
    private $dailycost;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


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
     * Get the value of name
     */ 
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail(?string $email)
    {
        $this->email = $email;

        return $this;
    }

    // /**
    //  * Get the value of job
    //  */ 
    // public function getJob() : ?Job
    // {
    //     return $this->job;
    // }

    // /**
    //  * Set the value of job
    //  *
    //  * @return  self
    //  */ 
    // public function setJob(?Job $job)
    // {
    //     $this->job = $job;

    //     return $this;
    // }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    // /**
    //  * @return Collection|Project[]
    //  */ 
    // public function getProjects(): Collection
    // {
    //     return $this->projects;
    // }

    // public function addProject(Project $project): self
    // {
    //     if (!$this->projects->contains($project)) {
    //         $this->projects[] = $project;
    //         $project->addWorker($this);
    //     }

    //     return $this;
    // }

    /**
     * Get the value of dailycost
     */ 
    public function getDailycost(): ?float
    {
        return $this->dailycost;
    }

    /**
     * Set the value of dailycost
     *
     * @return  self
     */ 
    public function setDailycost(?float $dailycost)
    {
        $this->dailycost = $dailycost;

        return $this;
    }
}