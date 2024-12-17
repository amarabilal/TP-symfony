<?php

namespace App\Entity;

use App\Repository\PlaylistSubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistSubscriptionRepository::class)]
class PlaylistSubscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $subscriptionDate = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Playlist::class, inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Playlist $subscribedPlaylist = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptionDate(): ?\DateTimeImmutable
    {
        return $this->subscriptionDate;
    }

    public function setSubscriptionDate(\DateTimeImmutable $subscriptionDate): self
    {
        $this->subscriptionDate = $subscriptionDate;

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

    public function getSubscribedPlaylist(): ?Playlist
    {
        return $this->subscribedPlaylist;
    }

    public function setSubscribedPlaylist(?Playlist $subscribedPlaylist): self
    {
        $this->subscribedPlaylist = $subscribedPlaylist;

        return $this;
    }
}
