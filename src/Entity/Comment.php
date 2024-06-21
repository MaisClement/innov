<?php

namespace App\Entity;

use App\Repository\CommentRepository;
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $answer = null;

    #[ORM\ManyToOne]
    private ?Account $author_answer_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $answer_date_time = null;

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

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getAuthorAnswerId(): ?Account
    {
        return $this->author_answer_id;
    }

    public function setAuthorAnswerId(?Account $author_answer_id): static
    {
        $this->author_answer_id = $author_answer_id;

        return $this;
    }

    public function getAnswerDateTime(): ?\DateTimeInterface
    {
        return $this->answer_date_time;
    }

    public function setAnswerDateTime(?\DateTimeInterface $answer_date_time): static
    {
        $this->answer_date_time = $answer_date_time;

        return $this;
    }
    
}
