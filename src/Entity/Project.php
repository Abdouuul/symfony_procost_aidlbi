<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\WorkTime;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\Table(name="app_project")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le nom du projet.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner la description du projet.")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le prix du projet.")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=WorkTime::class, mappedBy="project", orphanRemoval=true)
     */
    private $worktimes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deliveryDate;


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
     * Get the value of description
     */ 
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice(?string $price)
    {
        $this->price = $price;

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
     * Get the value of deliveryDate
     */ 
    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    /**
     * Set the value of deliveryDate
     *
     * @return  self
     */ 
    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

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
     * @return Collection|WorkTime[]
     */ 
    public function getWorktimes(): Collection
    {
        return $this->worktimes;
    }

    /**
     * Set the value of worktimes
     *
     * @return  self
     */ 
    public function addWorktime(WorkTime $worktimes): self
    {
        if (!$this->worktimes->contains($worktimes)) {
            $this->worktimes[] = $worktimes;
            $worktimes->setProject($this);
        }

        return $this;
    }
}