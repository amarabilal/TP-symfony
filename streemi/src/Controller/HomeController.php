<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MediaRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MediaRepository $mediaRepository): Response
    {
        $trendingMovies = $mediaRepository->findBy(
            ['type' => 'movie'],          
            ['releaseDate' => 'DESC'],    
            10                            
        );
        return $this->render('index.html.twig', [
            'trendingMovies' => $trendingMovies,
        ]);
    }
}
