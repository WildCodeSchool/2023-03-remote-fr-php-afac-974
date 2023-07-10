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
    #[Route('/{slug}', name: 'show')]
    public function show(Artist $artist): Response
    {

        return $this->render('artist/show.html.twig', [
            'artist' => $artist
        ]);
    }
}
