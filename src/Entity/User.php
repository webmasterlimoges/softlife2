<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
* @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $fistname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @var string password plain
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="creator", orphanRemoval=true)
     */
    private $projects;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="managers")
     */
    private $managementProjects;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Task", mappedBy="supervisors")
     */
    private $supervisorTasks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Task", mappedBy="technicians")
     */
    private $technicianTasks;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->managementProjects = new ArrayCollection();
        $this->supervisorTasks = new ArrayCollection();
        $this->technicianTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): string
    {

    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {

        $this->plainPassword = null;
    }

    public function getFistname(): ?string
    {
        return $this->fistname;
    }

    public function setFistname(string $fistname): self
    {
        $this->fistname = $fistname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getCreatorProjects(): Collection
    {
        return $this->projects;
    }

    public function addCreatorProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setCreator($this);
        }

        return $this;
    }

    public function removeCreatorProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCreator() === $this) {
                $project->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getManagementProjects(): Collection
    {
        return $this->managementProjects;
    }

    public function addManagementProject(Project $managementProject): self
    {
        if (!$this->managementProjects->contains($managementProject)) {
            $this->managementProjects[] = $managementProject;
            $managementProject->addManager($this);
        }

        return $this;
    }

    public function removeManagementProject(Project $managementProject): self
    {
        if ($this->managementProjects->contains($managementProject)) {
            $this->managementProjects->removeElement($managementProject);
            $managementProject->removeManager($this);
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getSupervisorTasks(): Collection
    {
        return $this->supervisorTasks;
    }

    public function addSupervisorTask(Task $supervisorTask): self
    {
        if (!$this->supervisorTasks->contains($supervisorTask)) {
            $this->supervisorTasks[] = $supervisorTask;
            $supervisorTask->addSupervisor($this);
        }

        return $this;
    }

    public function removeSupervisorTask(Task $supervisorTask): self
    {
        if ($this->supervisorTasks->contains($supervisorTask)) {
            $this->supervisorTasks->removeElement($supervisorTask);
            $supervisorTask->removeSupervisor($this);
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTechnicianTasks(): Collection
    {
        return $this->technicianTasks;
    }

    public function addTechnicianTask(Task $technicianTask): self
    {
        if (!$this->technicianTasks->contains($technicianTask)) {
            $this->technicianTasks[] = $technicianTask;
            $technicianTask->addTechnician($this);
        }

        return $this;
    }

    public function removeTechnicianTask(Task $technicianTask): self
    {
        if ($this->technicianTasks->contains($technicianTask)) {
            $this->technicianTasks->removeElement($technicianTask);
            $technicianTask->removeTechnician($this);
        }

        return $this;
    }
}
