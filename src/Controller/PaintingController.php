<?php

namespace App\Controller;

use App\Entity\Painting;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/painting', name: 'painting_')]
class PaintingController extends AbstractController
{
    #[Route('/{id}', name: 'show')]
    public function show(Painting $painting): Response
    {
        return $this->render('painting/show.html.twig', [
            'painting' => $painting,
        ]);
    }
}
