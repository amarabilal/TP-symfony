<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/users', name: 'users')]
    public function manageUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/categories', name: 'categories')]
    public function manageCategories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/medias', name: 'medias')]
    public function manageMedias(MediaRepository $mediaRepository): Response
    {
        $medias = $mediaRepository->findAll();

        return $this->render('admin/medias.html.twig', [
            'medias' => $medias,
        ]);
    }

    #[Route('/settings', name: 'settings')]
    public function settings(): Response
    {
        return $this->render('admin/settings.html.twig');
    }
}
