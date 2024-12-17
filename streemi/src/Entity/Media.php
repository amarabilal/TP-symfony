<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['movie' => Movie::class, 'serie' => Serie::class])]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summary = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publishedOn = null;

    #[ORM\Column(length: 255)]
    private ?string $thumbnail = null;

    #[ORM\Column(type: 'json')]
    private array $crew = [];

    #[ORM\Column(type: 'json')]
    private array $cast = [];

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Comment::class)]
    private Collection $feedback;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: WatchHistory::class)]
    private Collection $viewHistory;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: PlaylistMedia::class)]
    private Collection $relatedPlaylists;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'mediaItems')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Language::class, inversedBy: 'mediaItems')]
    private Collection $languages;

    public function __construct()
    {
        $this->feedback = new ArrayCollection();
        $this->viewHistory = new ArrayCollection();
        $this->relatedPlaylists = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->languages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPublishedOn(): ?\DateTimeInterface
    {
        return $this->publishedOn;
    }

    public function setPublishedOn(\DateTimeInterface $publishedOn): self
    {
        $this->publishedOn = $publishedOn;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getCrew(): array
    {
        return $this->crew;
    }

    public function setCrew(array $crew): self
    {
        $this->crew = $crew;

        return $this;
    }

    public function getCast(): array
    {
        return $this->cast;
    }

    public function setCast(array $cast): self
    {
        $this->cast = $cast;

        return $this;
    }

    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Comment $comment): self
    {
        if (!$this->feedback->contains($comment)) {
            $this->feedback->add($comment);
            $comment->setMedia($this);
        }

        return $this;
    }

    public function removeFeedback(Comment $comment): self
    {
        if ($this->feedback->removeElement($comment)) {
            if ($comment->getMedia() === $this) {
                $comment->setMedia(null);
            }
        }

        return $this;
    }

    public function getViewHistory(): Collection
    {
        return $this->viewHistory;
    }

    public function addViewHistory(WatchHistory $history): self
    {
        if (!$this->viewHistory->contains($history)) {
            $this->viewHistory->add($history);
            $history->setMedia($this);
        }

        return $this;
    }

    public function removeViewHistory(WatchHistory $history): self
    {
        if ($this->viewHistory->removeElement($history)) {
            if ($history->getMedia() === $this) {
                $history->setMedia(null);
            }
        }

        return $this;
    }

    public function getRelatedPlaylists(): Collection
    {
        return $this->relatedPlaylists;
    }

    public function addRelatedPlaylist(PlaylistMedia $playlistMedia): self
    {
        if (!$this->relatedPlaylists->contains($playlistMedia)) {
            $this->relatedPlaylists->add($playlistMedia);
            $playlistMedia->setMedia($this);
        }

        return $this;
    }

    public function removeRelatedPlaylist(PlaylistMedia $playlistMedia): self
    {
        if ($this->relatedPlaylists->removeElement($playlistMedia)) {
            if ($playlistMedia->getMedia() === $this) {
                $playlistMedia->setMedia(null);
            }
        }

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

        return $this;
    }
}
