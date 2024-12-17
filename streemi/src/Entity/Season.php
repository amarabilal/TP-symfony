<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $seasonNumber = null;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: Episode::class, cascade: ['persist', 'remove'])]
    private Collection $episodeList;

    #[ORM\ManyToOne(targetEntity: Serie::class, inversedBy: 'seasons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $parentSerie = null;

    public function __construct()
    {
        $this->episodeList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeasonNumber(): ?string
    {
        return $this->seasonNumber;
    }

    public function setSeasonNumber(string $seasonNumber): self
    {
        $this->seasonNumber = $seasonNumber;

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getEpisodeList(): Collection
    {
        return $this->episodeList;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodeList->contains($episode)) {
            $this->episodeList->add($episode);
            $episode->setSeason($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodeList->removeElement($episode)) {
            if ($episode->getSeason() === $this) {
                $episode->setSeason(null);
            }
        }

        return $this;
    }

    public function getParentSerie(): ?Serie
    {
        return $this->parentSerie;
    }

    public function setParentSerie(?Serie $parentSerie): self
    {
        $this->parentSerie = $parentSerie;

        return $this;
    }
}
