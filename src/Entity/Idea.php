<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;


#[ORM\Entity(repositoryClass: IdeaRepository::class)]
class Idea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\ManyToOne(inversedBy: 'ideas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $author = null;

    #[ORM\ManyToOne(inversedBy: 'ideas')]
    private ?Account $validator = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creation_datetime = null;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'related_idea')]
    private Collection $comments;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $choice_mesures = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details_mesures = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $choice_funding = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details_funding = null;

    #[ORM\Column(length: 255)]
    private ?string $team = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getAuthor(): ?Account
    {
        return $this->author;
    }

    public function setAuthor(?Account $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getValidator(): ?Account
    {
        return $this->validator;
    }

    public function setValidator(?Account $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCreationDatetime(): ?\DateTimeInterface
    {
        return $this->creation_datetime;
    }

    public function setCreationDatetime(\DateTimeInterface $creation_datetime)
    {
        $this->creation_datetime = $creation_datetime;

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
            $comment->setRelatedIdea($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRelatedIdea() === $this) {
                $comment->setRelatedIdea(null);
            }
        }

        return $this;
    }

    public function getChoiceMesures(): ?string
    {
        return $this->choice_mesures;
    }

    public function setChoiceMesures(string $choice_mesures): static
    {
        $this->choice_mesures = $choice_mesures;

        return $this;
    }

    public function getDetailsMesures(): ?string
    {
        return $this->details_mesures;
    }

    public function setDetailsMesures(string $details_mesures): static
    {
        $this->details_mesures = $details_mesures;

        return $this;
    }

    public function getChoiceFunding(): ?string
    {
        return $this->choice_funding;
    }

    public function setChoiceFunding(string $choice_funding): static
    {
        $this->choice_funding = $choice_funding;

        return $this;
    }

    public function getDetailsFunding(): ?string
    {
        return $this->details_funding;
    }

    public function setDetailsFunding(string $details_funding): static
    {
        $this->details_funding = $details_funding;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(string $team): static
    {
        $this->team = $team;

        return $this;
    }
}
