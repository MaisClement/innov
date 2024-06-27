<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
class Files
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    private ?Idea $related_idea_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $upload_date = null;

    #[ORM\Column(length: 255)]
    private ?string $name_file = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->upload_date;
    }

    public function setUploadDate(\DateTimeInterface $upload_date): static
    {
        $this->upload_date = $upload_date;

        return $this;
    }

    public function getNameFile(): ?string
    {
        return $this->name_file;
    }

    public function setNameFile(string $name_file): static
    {
        $this->name_file = $name_file;

        return $this;
    }
}
