<?php

namespace App\Entity;

use App\Repository\RolesAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesAccountRepository::class)]
class RolesAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'role_code')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $account_id = null;

    #[ORM\ManyToOne(inversedBy: 'rolesAccounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role_code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountId(): ?Account
    {
        return $this->account_id;
    }

    public function setAccountId(?Account $account_id): static
    {
        $this->account_id = $account_id;

        return $this;
    }

    public function getRoleCode(): ?Role
    {
        return $this->role_code;
    }

    public function setRoleCode(?Role $role_code): static
    {
        $this->role_code = $role_code;

        return $this;
    }
}
