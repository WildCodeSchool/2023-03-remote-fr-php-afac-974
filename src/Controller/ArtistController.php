<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/artist', name: 'artist_')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArtistRepository $artistRepository): Response
    {
        $artist = $artistRepository->findAll();
        return $this->render('artist/index.html.twig', [
            'artists' => $artist,
        ]);
    }
    #[Route('/{id}', name: 'show')]
    public function show(Artist $artist): Response
    {

        return $this->render('artist/show.html.twig', [
            'artist' => $artist
        ]);
    }
}
