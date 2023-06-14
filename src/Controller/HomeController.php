<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PaintingRepository $paintingRepository): Response
    {
        $paintings = $paintingRepository->findBy([], null, 4);

        return $this->render('home/index.html.twig', [
            'paintings' => $paintings,
        ]);
    }
}
