<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 3, unique: true)]
    private ?string $abbreviation = null;

    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'languages')]
    private Collection $associatedMedia;

    public function __construct()
    {
        $this->associatedMedia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getAssociatedMedia(): Collection
    {
        return $this->associatedMedia;
    }

    public function attachMedia(Media $media): self
    {
        if (!$this->associatedMedia->contains($media)) {
            $this->associatedMedia->add($media);
            $media->addLanguage($this);
        }

        return $this;
    }

    public function detachMedia(Media $media): self
    {
        if ($this->associatedMedia->removeElement($media)) {
            $media->removeLanguage($this);
        }

        return $this;
    }
}
