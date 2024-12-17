<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $details = null;

    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'categories')]
    private Collection $mediaCollection;

    public function __construct()
    {
        $this->mediaCollection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMediaCollection(): Collection
    {
        return $this->mediaCollection;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->mediaCollection->contains($media)) {
            $this->mediaCollection->add($media);
            $media->addCategory($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->mediaCollection->removeElement($media)) {
            $media->removeCategory($this);
        }

        return $this;
    }
}
