<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\PlaylistSubscription;
use App\Entity\Season;
use App\Entity\Serie;
use App\Entity\Subscription;
use App\Entity\SubscriptionHistory;
use App\Entity\User;
use App\Entity\WatchHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // === LANGUAGES ===
        $languages = [];
        foreach (['English', 'French', 'Spanish', 'German'] as $index => $label) {
            $language = new Language();
            $language->setLabel($label)->setAbbreviation(substr($label, 0, 2));
            $languages[] = $language;
            $manager->persist($language);
        }

        // === CATEGORIES ===
        $categories = [];
        foreach (['Action', 'Drama', 'Comedy', 'Sci-Fi'] as $label) {
            $category = new Category();
            $category->setTitle($label)->setDetails("Category for $label");
            $categories[] = $category;
            $manager->persist($category);
        }

        // === USERS ===
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $hashedPassword = $this->hasher->hashPassword($user, 'password');
            $user->setUsername("user$i")
                ->setEmailAddress("user$i@example.com")
                ->setPassword($hashedPassword)
                ->setStatus('active')
                ->setRoles(['ROLE_USER']);
            $users[] = $user;
            $manager->persist($user);
        }

        // === SUBSCRIPTIONS ===
        $subscriptions = [];
        foreach (['Monthly', 'Quarterly', 'Yearly'] as $index => $plan) {
            $subscription = new Subscription();
            $subscription->setPlanName("$plan Plan")
                ->setMonthlyCost(9.99 + ($index * 10))
                ->setDurationInMonths(($index + 1) * 3);
            $subscriptions[] = $subscription;
            $manager->persist($subscription);
        }

        // === MOVIES & SERIES ===
        $medias = [];
        for ($i = 1; $i <= 5; $i++) {
            $movie = new Movie();
            $movie->setName("Movie $i")
                ->setSummary("Short description for Movie $i")
                ->setDetails("Long description for Movie $i")
                ->setPublishedOn(new \DateTime())
                ->setThumbnail("https://via.placeholder.com/150")
                ->setCrew(['Director' => "Director $i"])
                ->setCast(['Actor' => "Actor $i"]);
            $medias[] = $movie;
            $manager->persist($movie);

            $serie = new Serie();
            $serie->setName("Serie $i")
                ->setSummary("Short description for Serie $i")
                ->setDetails("Long description for Serie $i")
                ->setPublishedOn(new \DateTime())
                ->setThumbnail("https://via.placeholder.com/150")
                ->setCrew(['Producer' => "Producer $i"])
                ->setCast(['Lead' => "Lead $i"]);
            $medias[] = $serie;
            $manager->persist($serie);

            // === SEASONS & EPISODES ===
            for ($j = 1; $j <= 2; $j++) {
                $season = new Season();
                $season->setSeasonNumber("Season $j")->setParentSerie($serie);
                $manager->persist($season);

                for ($k = 1; $k <= 3; $k++) {
                    $episode = new Episode();
                    $episode->setEpisodeTitle("Episode $k")
                        ->setRuntime(rand(20, 50))
                        ->setAirDate(new \DateTimeImmutable())
                        ->setParentSeason($season);
                    $manager->persist($episode);
                }
            }
        }

        // === PLAYLISTS ===
        foreach ($users as $user) {
            $playlist = new Playlist();
            $playlist->setTitle("Playlist of {$user->getUsername()}")
                ->setCreatedOn(new \DateTimeImmutable())
                ->setUpdatedOn(new \DateTimeImmutable())
                ->setOwner($user);
            $manager->persist($playlist);

            foreach ($medias as $media) {
                $playlistMedia = new PlaylistMedia();
                $playlistMedia->setParentPlaylist($playlist)
                    ->setAssociatedMedia($media)
                    ->setDateAdded(new \DateTimeImmutable());
                $manager->persist($playlistMedia);
            }
        }

        // === COMMENTS WITH REPLIES ===
        $comments = [];
        foreach ($users as $user) {
            foreach ($medias as $media) {
                $comment = new Comment();
                $comment->setAuthor($user)
                        ->setAssociatedMedia($media)
                        ->setMessage("This is a comment on {$media->getName()}")
                        ->setParentComment(null);

                $comments[] = $comment;
                $manager->persist($comment);
            }
        }

        // Ajouter des réponses à certains commentaires
        foreach ($comments as $parentComment) {
            if (rand(0, 1)) { // 50% de chance d'ajouter une réponse
                $reply = new Comment();
                $reply->setAuthor($users[array_rand($users)])
                    ->setAssociatedMedia($parentComment->getAssociatedMedia())
                    ->setMessage("This is a reply to comment {$parentComment->getId()}")
                    ->setParentComment($parentComment);

                $manager->persist($reply);
            }
        }

        // === WATCH HISTORY ===
        foreach ($users as $user) {
            foreach ($medias as $media) {
                $history = new WatchHistory();
                $history->setUser($user)
                    ->setContent($media)
                    ->setViewedAt(new \DateTimeImmutable())
                    ->setViewCount(rand(1, 10));
                $manager->persist($history);
            }
        }

        // === SUBSCRIPTION HISTORIES ===
        foreach ($users as $user) {
            $history = new SubscriptionHistory();
            $history->setUser($user)
                ->setPlan($subscriptions[array_rand($subscriptions)])
                ->setStartedOn(new \DateTimeImmutable('-1 month'))
                ->setEndedOn(new \DateTimeImmutable('+1 month'));
            $manager->persist($history);
        }

        $manager->flush();
    }
}
