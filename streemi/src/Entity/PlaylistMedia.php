<?php

namespace App\Entity;

use App\Repository\PlaylistMediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistMediaRepository::class)]
class PlaylistMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateAdded = null;

    #[ORM\ManyToOne(targetEntity: Playlist::class, inversedBy: 'mediaItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Playlist $parentPlaylist = null;

    #[ORM\ManyToOne(targetEntity: Media::class, inversedBy: 'playlists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $associatedMedia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAdded(): ?\DateTimeImmutable
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTimeImmutable $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getParentPlaylist(): ?Playlist
    {
        return $this->parentPlaylist;
    }

    public function setParentPlaylist(?Playlist $parentPlaylist): self
    {
        $this->parentPlaylist = $parentPlaylist;

        return $this;
    }

    public function getAssociatedMedia(): ?Media
    {
        return $this->associatedMedia;
    }

    public function setAssociatedMedia(?Media $associatedMedia): self
    {
        $this->associatedMedia = $associatedMedia;

        return $this;
    }
}
