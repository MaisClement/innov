<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $answer_content = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    private ?Comment $related_comment_id = null;

    #[ORM\Column]
    private ?int $answer_author_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $AnswerDateTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswerContent(): ?string
    {
        return $this->answer_content;
    }

    public function setAnswerContent(?string $answer_content): static
    {
        $this->answer_content = $answer_content;

        return $this;
    }

    public function getRelatedCommentId(): ?Comment
    {
        return $this->related_comment_id;
    }

    public function setRelatedCommentId(?Comment $related_comment_id): static
    {
        $this->related_comment_id = $related_comment_id;

        return $this;
    }

    public function getAnswerAuthorId(): ?int
    {
        return $this->answer_author_id;
    }

    public function setAnswerAuthorId(int $answer_author_id): static
    {
        $this->answer_author_id = $answer_author_id;

        return $this;
    }

    public function getAnswerDateTime(): ?\DateTimeInterface
    {
        return $this->AnswerDateTime;
    }

    public function setAnswerDateTime(\DateTimeInterface $AnswerDateTime): static
    {
        $this->AnswerDateTime = $AnswerDateTime;

        return $this;
    }
}
