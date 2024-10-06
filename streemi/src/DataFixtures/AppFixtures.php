<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Language;
use App\Entity\Movie;
use App\Entity\Serie;
use App\Entity\User;
use App\Entity\WatchHistory;
use App\Entity\SubscriptionHistory;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Enum\UserAccountStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = $this->generateUsers($manager);
        $medias = $this->generateMedias($manager);
        $categories = $this->generateCategories($manager, $medias);
        $languages = $this->generateLanguages($manager, $medias);
        $this->generateWatchHistory($manager, $users, $medias);
        $this->generateSubscriptionHistories($manager, $users);
        $this->generatePlaylists($manager, $users, $medias);

        $manager->flush();
    }

    private function generateUsers(ObjectManager $manager)
    {
        $users = [];
        for ($i = 0; $i < random_int(10, 20); $i++) {
            $user = new User();
            $user->setUsername("user_{$i}");
            $user->setEmail("email_{$i}@example.com");
            $user->setPassword('motdepasse');
            $user->setAccountStatus(UserAccountStatusEnum::ACTIVE);
            $users[] = $user;
            $manager->persist($user);
        }

        return $users;
    }

    private function generateLanguages(ObjectManager $manager, array $medias): array
    {
        $tabs = [['fr', 'Français'], ['en', 'Anglais'], ['es', 'Espagnol']];
        $languages = [];

        foreach ($tabs as $tab) {
            $entity = new Language();
            $entity->setCode($tab[0]);
            $entity->setNom($tab[1]);
            $manager->persist($entity);
            $languages[] = $entity;

            foreach ($medias as $media) {
                if (random_int(0, 1)) { // Ajout aléatoire de langues
                    $media->addLanguage($entity);
                }
            }
        }

        return $languages;
    }

    private function generateCategories(ObjectManager $manager, array $medias): array
    {
        $categories = [];
        $tabs = ['Action', 'Aventure', 'Comédie', 'Drame', 'Fantastique'];
        foreach ($tabs as $tab) {
            $category = new Category();
            $category->setLabel($tab);
            $category->setNom(strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $tab)));
            $manager->persist($category);
            $categories[] = $category;

            foreach ($medias as $media) {
                if (random_int(0, 1)) { // Ajout aléatoire de catégories
                    $media->addCategory($category);
                }
            }
        }

        return $categories;
    }

    private function generateMedias(ObjectManager $manager): array
    {
        $medias = [];
        for ($j = 0; $j < random_int(10, 20); $j++) {
            $movie = new Movie();
            $movie->setTitle("movie_{$j}");
            $movie->setShortDescription("short description for movie_{$j}");
            $movie->setLongDescription("long description for movie_{$j}");
            $movie->setCoverImage("cover_image_{$j}.png");
            $movie->setReleaseDate(new \DateTime());
            $movie->setCasting([]);
            $movie->setStaff([]);
            $medias[] = $movie;
            $manager->persist($movie);
        }

        for ($j = 0; $j < random_int(10, 20); $j++) {
            $serie = new Serie();
            $serie->setTitle("serie_{$j}");
            $serie->setShortDescription("short description for serie_{$j}");
            $serie->setLongDescription("long description for serie_{$j}");
            $serie->setCoverImage("cover_image_{$j}.png");
            $serie->setReleaseDate(new \DateTime());
            $serie->setCasting([]);
            $serie->setStaff([]);
            $medias[] = $serie;
            $manager->persist($serie);
        }
        
        return $medias;
    }

    private function generateWatchHistory(ObjectManager $manager, array $users, array $medias)
    {
        foreach ($users as $user) {
            for ($k = 0; $k < random_int(1, 5); $k++) {
                $watchHistory = new WatchHistory();
                $watchHistory->setUser($user);
                $watchHistory->setMedia($medias[array_rand($medias)]);
                $watchHistory->setLastWatchedAt(new \DateTime());
                $watchHistory->setNumberOfViews(random_int(1, 10));
                $manager->persist($watchHistory);
            }
        }
    }

    private function generateSubscriptionHistories(ObjectManager $manager, array $users)
    {
        foreach ($users as $user) {
            $subscriptionHistory = new SubscriptionHistory();
            $subscriptionHistory->setUser($user);
            $subscriptionHistory->setStartDate(new \DateTime());
            $subscriptionHistory->setEndDate((new \DateTime())->modify('+1 month'));
            $manager->persist($subscriptionHistory);
        }
    }

    private function generatePlaylists(ObjectManager $manager, array $users, array $medias)
    {
        foreach ($users as $user) {
            $playlist = new Playlist();
            $playlist->setUser($user);
            $playlist->setName("Playlist de {$user->getUsername()}");
            $manager->persist($playlist);

            for ($k = 0; $k < random_int(1, 5); $k++) {
                $playlistMedia = new PlaylistMedia();
                $playlistMedia->setPlaylist($playlist);
                $playlistMedia->setMedia($medias[array_rand($medias)]);
                $playlistMedia->setAddedAt(new \DateTime());
                $manager->persist($playlistMedia);
            }
        }
    }
}
