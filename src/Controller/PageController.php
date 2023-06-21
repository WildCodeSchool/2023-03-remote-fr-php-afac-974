<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/page', name: 'app_page_')]
class PageController extends AbstractController
{
    #[Route('/mentions-legales', name: 'show')]
    public function show(): Response
    {
        return $this->render('page/show.html.twig');
    }
}
