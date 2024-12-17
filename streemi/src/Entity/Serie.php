<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie extends Media
{
    #[ORM\OneToMany(mappedBy: 'serie', targetEntity: Season::class, cascade: ['persist', 'remove'])]
    private Collection $seasons;

    public function __construct()
    {
        parent::__construct();
        $this->seasons = new ArrayCollection();
    }

    /**
     * Retrieve all seasons associated with the series.
     *
     * @return Collection<int, Season>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    /**
     * Link a season to the series.
     *
     * @param Season $season The season to associate.
     * @return $this
     */
    public function addSeason(Season $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setSerie($this);
        }

        return $this;
    }

    /**
     * Unlink a season from the series.
     *
     * @param Season $season The season to dissociate.
     * @return $this
     */
    public function removeSeason(Season $season): self
    {
        if ($this->seasons->removeElement($season)) {
            if ($season->getSerie() === $this) {
                $season->setSerie(null);
            }
        }

        return $this;
    }
}
