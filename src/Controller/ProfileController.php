<?php

 namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
    return $this->render('profile/index.html.twig');
     }

     #[Route('/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('profile/edit.html.twig');
    }
}
