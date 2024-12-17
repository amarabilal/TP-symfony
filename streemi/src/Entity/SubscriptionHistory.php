<?php

namespace App\Entity;

use App\Repository\SubscriptionHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionHistoryRepository::class)]
class SubscriptionHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $startedOn = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $endedOn = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'subscriptionRecords')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Subscription::class, inversedBy: 'subscriptionRecords')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $plan = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedOn(): ?\DateTimeImmutable
    {
        return $this->startedOn;
    }

    public function setStartedOn(\DateTimeImmutable $startedOn): self
    {
        $this->startedOn = $startedOn;

        return $this;
    }

    public function getEndedOn(): ?\DateTimeImmutable
    {
        return $this->endedOn;
    }

    public function setEndedOn(\DateTimeImmutable $endedOn): self
    {
        $this->endedOn = $endedOn;

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

    public function getPlan(): ?Subscription
    {
        return $this->plan;
    }

    public function setPlan(?Subscription $plan): self
    {
        $this->plan = $plan;

        return $this;
    }
}
