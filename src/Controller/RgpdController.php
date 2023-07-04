<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rgpd')]
class RgpdController extends AbstractController
{
    #[Route('/', name: 'app_page_index')]
    public function index(): Response
    {
        return $this->render('rgpd/index.html.twig', []);
    }
}
