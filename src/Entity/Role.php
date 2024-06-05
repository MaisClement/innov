<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'roles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $account_id = null;

    #[ORM\Column(length:255)]
    private ?string $role = 'default';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountId(): ?Account
    {
        return $this->$account_id;
    }

    public function getRole(): ?string
    {
        return $this->$role;
    }
}
