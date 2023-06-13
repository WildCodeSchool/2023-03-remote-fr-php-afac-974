<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/galery', name: 'galery_')]
class GaleryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PaintingRepository $paintingRepositery): Response
    {
        $paintings = $paintingRepositery->findAll();

        return $this->render('galery/index.html.twig', [
            'paintings' => $paintings,
        ]);
    }
}
