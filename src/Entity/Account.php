<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $family_name = null;

    #[ORM\Column(length: 255)]
    private ?string $given_name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $ms_oid = null;

    #[ORM\Column]
    private ?bool $is_active = true;

    #[ORM\OneToMany(targetEntity: Login::class, mappedBy: 'account_id', orphanRemoval: true)]
    private Collection $logins;

    #[ORM\OneToMany(targetEntity: Idea::class, mappedBy: 'author')]
    private Collection $ideas;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'author')]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'auhtor')]
    private Collection $votes;

    #[ORM\OneToMany(targetEntity: Role::class, mappedBy: 'account_id')]
    private Collection $role;

    public function __construct()
    {
        $this->logins = new ArrayCollection();
        $this->ideas = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->role = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMsOid(): ?string
    {
        return $this->ms_oid;
    }

    public function setMsOid(string $ms_oid): static
    {
        $this->ms_oid = $ms_oid;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, Login>
     */
    public function getLogins(): Collection
    {
        return $this->logins;
    }

    public function addLogin(Login $login): static
    {
        if (!$this->logins->contains($login)) {
            $this->logins->add($login);
            $login->setAccountId($this);
        }

        return $this;
    }

    public function removeLogin(Login $login): static
    {
        if ($this->logins->removeElement($login)) {
            // set the owning side to null (unless already changed)
            if ($login->getAccountId() === $this) {
                $login->setAccountId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Idea>
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    public function addIdea(Idea $idea): static
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas->add($idea);
            $idea->setAuthor($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): static
    {
        if ($this->ideas->removeElement($idea)) {
            // set the owning side to null (unless already changed)
            if ($idea->getAuthor() === $this) {
                $idea->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setAuhtor($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getAuhtor() === $this) {
                $vote->setAuhtor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(Role $role): static
    {
        if (!$this->role->contains($role)) {
            $this->role->add($role);
            $role->setAccountId($this);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        if ($this->role->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getAccountId() === $this) {
                $role->setAccountId(null);
            }
        }

        return $this;
    }

}
