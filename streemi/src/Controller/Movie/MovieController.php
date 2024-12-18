<?php

namespace App\Controller\Movie;

use App\Repository\MovieRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movies', name: 'app_movies')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/movie/{id}', name: 'app_movie_detail')]
    public function detail(int $id, MovieRepository $movieRepository): Response
    {
        $movie = $movieRepository->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Movie not found.');
        }

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/discover', name: 'app_movie_discover')]
    public function discover(MediaRepository $mediaRepository): Response
    {
        $movies = $mediaRepository->findBy([], ['releaseDate' => 'DESC']);

        return $this->render('movie/discover.html.twig', [
            'recommendedMovies' => $movies,
        ]);
    }
}
