<?php

namespace App\Entity;

use App\Repository\CriticaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CriticaRepository::class)]
class Critica
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $movieId = null;

    #[ORM\Column(length: 255)]
    private ?string $userId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $criticatext = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieId(): ?int
    {
        return $this->movieId;
    }

    public function setMovieId(int $movieId): static
    {
        $this->movieId = $movieId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCriticatext(): ?string
    {
        return $this->criticatext;
    }

    public function setCriticatext(?string $criticatext): static
    {
        $this->criticatext = $criticatext;

        return $this;
    }
}
