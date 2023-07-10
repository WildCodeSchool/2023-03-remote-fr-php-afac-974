<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Painting;
use App\Repository\PaintingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'app_profile')]
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
