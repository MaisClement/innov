<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $role_code = null;

    #[ORM\Column(length: 255)]
    private ?string $role_name = null;

    #[ORM\OneToMany(targetEntity: RolesAccount::class, mappedBy: 'role_code')]
    private Collection $rolesAccounts;

    public function __construct()
    {
        $this->rolesAccounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleCode(): ?string
    {
        return $this->role_code;
    }

    public function setRoleCode(string $role_code): static
    {
        $this->role_code = $role_code;

        return $this;
    }

    public function getRoleName(): ?string
    {
        return $this->role_name;
    }

    public function setRoleName(string $role_name): static
    {
        $this->role_name = $role_name;

        return $this;
    }

    /**
     * @return Collection<int, RolesAccount>
     */
    public function getRolesAccounts(): Collection
    {
        return $this->rolesAccounts;
    }

    public function addRolesAccount(RolesAccount $rolesAccount): static
    {
        if (!$this->rolesAccounts->contains($rolesAccount)) {
            $this->rolesAccounts->add($rolesAccount);
            $rolesAccount->setRoleCode($this);
        }

        return $this;
    }

    public function removeRolesAccount(RolesAccount $rolesAccount): static
    {
        if ($this->rolesAccounts->removeElement($rolesAccount)) {
            // set the owning side to null (unless already changed)
            if ($rolesAccount->getRoleCode() === $this) {
                $rolesAccount->setRoleCode(null);
            }
        }

        return $this;
    }
}
