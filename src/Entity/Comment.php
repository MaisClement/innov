<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Account $author = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Idea $related_idea = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDateTime = null;

    /**
     * @var Collection<int, Answer>
     */
    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'author')]
    private Collection $answer;

    /**
     * @var Collection<int, Answer>
     */
    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'related_comment_id')]
    private Collection $answers;

    public function __construct()
    {
        $this->answer = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

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

    public function getRelatedIdea(): ?Idea
    {
        return $this->related_idea;
    }

    public function setRelatedIdea(?Idea $related_idea): static
    {
        $this->related_idea = $related_idea;

        return $this;
    }

    public function getCreationDateTime(): ?\DateTimeInterface
    {
        return $this->creationDateTime;
    }

    public function setCreationDateTime(\DateTimeInterface $creationDateTime): static
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswer(): Collection
    {
        return $this->answer;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answer->contains($answer)) {
            $this->answer->add($answer);
            $answer->setAuthor($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answer->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getAuthor() === $this) {
                $answer->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }
    
}
