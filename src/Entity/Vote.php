<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Account $auhtor = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Idea $related_idea_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuhtor(): ?Account
    {
        return $this->auhtor;
    }

    public function setAuhtor(?Account $auhtor): static
    {
        $this->auhtor = $auhtor;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getRelatedIdeaId(): ?Idea
    {
        return $this->related_idea_id;
    }

    public function setRelatedIdeaId(?Idea $related_idea_id): static
    {
        $this->related_idea_id = $related_idea_id;

        return $this;
    }
}
