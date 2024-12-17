<?php

namespace App\Entity;

use App\Repository\WatchHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchHistoryRepository::class)]
class WatchHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $viewedAt = null;

    #[ORM\Column(type: 'integer')]
    private ?int $viewCount = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'watchHistory')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Media::class, inversedBy: 'watchHistory')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViewedAt(): ?\DateTimeImmutable
    {
        return $this->viewedAt;
    }

    public function setViewedAt(\DateTimeImmutable $viewedAt): self
    {
        $this->viewedAt = $viewedAt;

        return $this;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    public function setViewCount(int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?Media
    {
        return $this->content;
    }

    public function setContent(?Media $content): self
    {
        $this->content = $content;

        return $this;
    }
}
