<?php

namespace App\Controller;

use App\Entity\Painting;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'app_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'profile')]

    public function index(PaintingRepository $paintingRepository): Response
    {
        $paintings = $paintingRepository->findAll();

        $user = $this->getUser();

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'paintings' => $paintings,
            'user' => $user
        ]);
    }
}
