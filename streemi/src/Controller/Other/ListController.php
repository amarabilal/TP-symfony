<?php

namespace App\Controller\Other;

use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/playlists', name: 'app_playlists')]
    public function index(PlaylistRepository $playlistRepository): Response
    {
        $playlists = $playlistRepository->findAll();

        return $this->render('list/index.html.twig', [
            'playlists' => $playlists,
        ]);
    }

    #[Route('/playlist/{id}', name: 'app_playlist_detail')]
    public function detail(int $id, PlaylistRepository $playlistRepository): Response
    {
        $playlist = $playlistRepository->find($id);

        if (!$playlist) {
            throw $this->createNotFoundException('Playlist not found.');
        }

        return $this->render('list/detail.html.twig', [
            'playlist' => $playlist,
        ]);
    }
}
