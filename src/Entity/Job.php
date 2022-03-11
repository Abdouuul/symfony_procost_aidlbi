<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JobRepository::class)
 * @ORM\Table(name="app_job")
 */
class Job{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le nom du métier.")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Worker::class, mappedBy="job", orphanRemoval=true)
     */
    private $workers;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->workers = new ArrayCollection();
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
    public function setName(?string $name)
    {
        $this->name = $name;

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
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Worker[]
     */ 
    public function getWorkers(): Collection
    {
        return $this->workers;
    }

    /**
     * Set the value of workers
     *
     * @return  self
     */ 
    public function addWorker(Worker $worker)
    {
        if (!$this->workers->contains($worker)) {
            $this->workers[] = $worker;
            $worker->setJob($this);
        }

        return $this;
    }

    /**
     * Remove workers
     *
     * @return  self
     */
    public function removeWorker(Worker $worker)
    {
        if ($this->workers->contains($worker)) {
            $this->workers->removeElement($worker);
            // set the owning side to null (unless already changed)
            if ($worker->getJob() === $this) {
                $worker->setJob(null);
            }
        }
        return $this;
    }
}