<?php

namespace App\Entity;

use App\Repository\ManagersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManagersRepository::class)]
class Managers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $family_name = null;

    #[ORM\Column(length: 255)]
    private ?string $given_name = null;

    #[ORM\ManyToOne(inversedBy: 'manager')]
    #[ORM\JoinColumn(nullable: false)]
    private ?teams $team_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyName(): ?string
    {
        return $this->family_name;
    }

    public function setFamilyName(string $family_name): static
    {
        $this->family_name = $family_name;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->given_name;
    }

    public function setGivenName(string $given_name): static
    {
        $this->given_name = $given_name;

        return $this;
    }

    public function getTeamId(): ?teams
    {
        return $this->team_id;
    }

    public function setTeamId(?teams $team_id): static
    {
        $this->team_id = $team_id;

        return $this;
    }
}
