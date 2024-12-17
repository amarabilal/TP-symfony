<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EpisodeRepository;
#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $episodeTitle = null;

    #[ORM\Column(type: 'integer')]
    private ?int $runtime = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $airDate = null;

    #[ORM\ManyToOne(targetEntity: Season::class, inversedBy: 'episodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Season $parentSeason = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEpisodeTitle(): ?string
    {
        return $this->episodeTitle;
    }

    public function setEpisodeTitle(string $episodeTitle): self
    {
        $this->episodeTitle = $episodeTitle;

        return $this;
    }

    public function getRuntime(): ?int
    {
        return $this->runtime;
    }

    public function setRuntime(int $runtime): self
    {
        $this->runtime = $runtime;

        return $this;
    }

    public function getAirDate(): ?\DateTimeImmutable
    {
        return $this->airDate;
    }

    public function setAirDate(\DateTimeImmutable $airDate): self
    {
        $this->airDate = $airDate;

        return $this;
    }

    public function getParentSeason(): ?Season
    {
        return $this->parentSeason;
    }

    public function setParentSeason(?Season $parentSeason): self
    {
        $this->parentSeason = $parentSeason;

        return $this;
    }
}
