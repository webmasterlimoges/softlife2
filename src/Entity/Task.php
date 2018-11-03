<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="supervisorTasks")
     * @ORM\JoinTable(
     *     name="supervisors_tasks",
     *  joinColumns={
     *      @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  }
     * )
     */
    private $supervisors;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="technicianTasks")
     * @ORM\JoinTable(
     *     name="technicians_tasks",
     *  joinColumns={
     *      @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *  }
     * )
     */
    private $technicians;

    public function __construct()
    {
        $this->supervisors = new ArrayCollection();
        $this->technicians = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSupervisors(): Collection
    {
        return $this->supervisors;
    }

    public function addSupervisor(User $supervisor): self
    {
        if (!$this->supervisors->contains($supervisor)) {
            $this->supervisors[] = $supervisor;
        }

        return $this;
    }

    public function removeSupervisor(User $supervisor): self
    {
        if ($this->supervisors->contains($supervisor)) {
            $this->supervisors->removeElement($supervisor);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getTechnicians(): Collection
    {
        return $this->technicians;
    }

    public function addTechnician(User $technician): self
    {
        if (!$this->technicians->contains($technician)) {
            $this->technicians[] = $technician;
        }

        return $this;
    }

    public function removeTechnician(User $technician): self
    {
        if ($this->technicians->contains($technician)) {
            $this->technicians->removeElement($technician);
        }

        return $this;
    }
}
