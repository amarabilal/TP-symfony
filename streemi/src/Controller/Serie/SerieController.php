<?php

namespace App\Controller\Serie;

use App\Repository\SerieRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    #[Route('/series', name: 'app_series')]
    public function index(SerieRepository $serieRepository): Response
    {
        $series = $serieRepository->findAll();

        return $this->render('serie/index.html.twig', [
            'series' => $series,
        ]);
    }

    #[Route('/serie/{id}', name: 'app_serie_detail')]
    public function detail(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException('Serie not found.');
        }

        return $this->render('serie/detail.html.twig', [
            'serie' => $serie,
        ]);
    }

    #[Route('/discover', name: 'app_serie_discover')]
    public function discover(MediaRepository $mediaRepository): Response
    {
        $series = $mediaRepository->findBy([], ['releaseDate' => 'DESC']);

        return $this->render('serie/discover.html.twig', [
            'recommendedSeries' => $series,
        ]);
    }
}
