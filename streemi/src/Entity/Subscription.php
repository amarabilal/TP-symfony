<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $planName = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $monthlyCost = null;

    #[ORM\Column(type: 'integer')]
    private ?int $durationInMonths = null;

    #[ORM\OneToMany(mappedBy: 'currentSubscription', targetEntity: User::class)]
    private Collection $subscribers;

    #[ORM\OneToMany(mappedBy: 'plan', targetEntity: SubscriptionHistory::class)]
    private Collection $subscriptionRecords;

    public function __construct()
    {
        $this->subscribers = new ArrayCollection();
        $this->subscriptionRecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlanName(): ?string
    {
        return $this->planName;
    }

    public function setPlanName(string $planName): self
    {
        $this->planName = $planName;

        return $this;
    }

    public function getMonthlyCost(): ?float
    {
        return $this->monthlyCost;
    }

    public function setMonthlyCost(float $monthlyCost): self
    {
        $this->monthlyCost = $monthlyCost;

        return $this;
    }

    public function getDurationInMonths(): ?int
    {
        return $this->durationInMonths;
    }

    public function setDurationInMonths(int $durationInMonths): self
    {
        $this->durationInMonths = $durationInMonths;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSubscribers(): Collection
    {
        return $this->subscribers;
    }

    public function addSubscriber(User $subscriber): self
    {
        if (!$this->subscribers->contains($subscriber)) {
            $this->subscribers->add($subscriber);
            $subscriber->setCurrentSubscription($this);
        }

        return $this;
    }

    public function removeSubscriber(User $subscriber): self
    {
        if ($this->subscribers->removeElement($subscriber)) {
            if ($subscriber->getCurrentSubscription() === $this) {
                $subscriber->setCurrentSubscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionHistory>
     */
    public function getSubscriptionRecords(): Collection
    {
        return $this->subscriptionRecords;
    }

    public function addSubscriptionRecord(SubscriptionHistory $record): self
    {
        if (!$this->subscriptionRecords->contains($record)) {
            $this->subscriptionRecords->add($record);
            $record->setPlan($this);
        }

        return $this;
    }

    public function removeSubscriptionRecord(SubscriptionHistory $record): self
    {
        if ($this->subscriptionRecords->removeElement($record)) {
            if ($record->getPlan() === $this) {
                $record->setPlan(null);
            }
        }

        return $this;
    }
}
