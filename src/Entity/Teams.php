<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamsRepository::class)]
class Teams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label_teams = null;

    /**
     * @var Collection<int, Teams>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'manager_id')]
    private Collection $teams;

    /**
     * @var Collection<int, Managers>
     */
    #[ORM\OneToMany(targetEntity: Managers::class, mappedBy: 'team_id')]
    private Collection $manager;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->manager = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabelTeams(): ?string
    {
        return $this->label_teams;
    }

    public function setLabelTeams(string $label_teams): static
    {
        $this->label_teams = $label_teams;

        return $this;
    }

    /**
     * @return Collection<int, Teams>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(self $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setManagerId($this);
        }

        return $this;
    }

    public function removeTeam(self $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getManagerId() === $this) {
                $team->setManagerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Managers>
     */
    public function getManager(): Collection
    {
        return $this->manager;
    }

    public function addManager(Managers $manager): static
    {
        if (!$this->manager->contains($manager)) {
            $this->manager->add($manager);
            $manager->setTeamId($this);
        }

        return $this;
    }

    public function removeManager(Managers $manager): static
    {
        if ($this->manager->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getTeamId() === $this) {
                $manager->setTeamId(null);
            }
        }

        return $this;
    }
}
