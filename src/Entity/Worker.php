<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\WorkTime;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)\
 * @ORM\Table(name="app_worker")
 */
class Worker
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le prénom.")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le nom.")
     */
    private $lastName;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner l'email.")
     * @Assert\Email(message="L'email {{ value }} n'est pas valide.")
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Job::class, inversedBy="workers")
     * @ORM\JoinColumn(nullable=false, name="app_job_id")
     * @Assert\NotBlank(message="Veuillez choisir un métier.")
     */
    private $job;

    /**
     * @ORM\Column(type="float", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le coût journalier.")
     */
    private $dailycost;

    /**
     * @ORM\OneToMany(targetEntity=WorkTime::class, mappedBy="worker", orphanRemoval=true)
     */
    private $worktimes;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Veuillez renseigner la date d'embauche.")
     */
    private $employedAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->worktimes = new ArrayCollection();
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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

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

    /**
     * Get the value of job
     */ 
    public function getJob() : ?Job
    {
        return $this->job;
    }

    /**
     * Set the value of job
     *
     * @return  self
     */ 
    public function setJob(?Job $job)
    {
        $this->job = $job;

        return $this;
    }

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

    

    /**
     * Get the value of employedAt
     */ 
    public function getEmployedAt(): ?\DateTimeInterface
    {
        return $this->employedAt;
    }

    /**
     * Set the value of employedAt
     *
     * @return  self
     */ 
    public function setEmployedAt(\DateTimeInterface $employedAt):self
    {
        $this->employedAt = $employedAt;

        return $this;
    }

    /**
     * @return Collection|WorkTime[]
     */ 
    public function getWorktimes(): Collection
    {
        return $this->worktimes;
    }

    public function addWorktime(WorkTime $worktimes)
    {
        if (!$this->worktimes->contains($worktimes)) {
            $this->worktimes[] = $worktimes;
            $worktimes->setWorker($this);
        }
        return $this;
    }
}