<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdOn = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedOn = null;

    #[ORM\OneToMany(mappedBy: 'playlist', targetEntity: PlaylistSubscription::class, cascade: ['persist', 'remove'])]
    private Collection $subscriptions;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'createdPlaylists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'playlist', targetEntity: PlaylistMedia::class, cascade: ['persist', 'remove'])]
    private Collection $mediaItems;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->mediaItems = new ArrayCollection();
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

    public function getCreatedOn(): ?\DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function setCreatedOn(\DateTimeImmutable $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function getUpdatedOn(): ?\DateTimeImmutable
    {
        return $this->updatedOn;
    }

    public function setUpdatedOn(\DateTimeImmutable $updatedOn): self
    {
        $this->updatedOn = $updatedOn;

        return $this;
    }

    /**
     * @return Collection<int, PlaylistSubscription>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(PlaylistSubscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->add($subscription);
            $subscription->setPlaylist($this);
        }

        return $this;
    }

    public function removeSubscription(PlaylistSubscription $subscription): self
    {
        if ($this->subscriptions->removeElement($subscription)) {
            if ($subscription->getPlaylist() === $this) {
                $subscription->setPlaylist(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, PlaylistMedia>
     */
    public function getMediaItems(): Collection
    {
        return $this->mediaItems;
    }

    public function addMediaItem(PlaylistMedia $mediaItem): self
    {
        if (!$this->mediaItems->contains($mediaItem)) {
            $this->mediaItems->add($mediaItem);
            $mediaItem->setPlaylist($this);
        }

        return $this;
    }

    public function removeMediaItem(PlaylistMedia $mediaItem): self
    {
        if ($this->mediaItems->removeElement($mediaItem)) {
            if ($mediaItem->getPlaylist() === $this) {
                $mediaItem->setPlaylist(null);
            }
        }

        return $this;
    }

    public function getMovies(): Collection
    {
        $movies = $this->mediaItems->filter(fn($mediaItem) => $mediaItem->getMedia() instanceof Movie);
        return new ArrayCollection(iterator_to_array($movies));
    }

    public function getSeries(): Collection
    {
        $series = $this->mediaItems->filter(fn($mediaItem) => $mediaItem->getMedia() instanceof Serie);
        return new ArrayCollection(iterator_to_array($series));
    }
}
