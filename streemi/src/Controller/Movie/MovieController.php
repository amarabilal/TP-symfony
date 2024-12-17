<?php

namespace App\Controller\Movie;

use App\Repository\MovieRepository;
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
}
