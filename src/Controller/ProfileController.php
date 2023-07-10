<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Painting;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'app_profile')]
    public function index( Painting $paintings, user $user): Response
    {
        return $this->render(
            'profile/index.html.twig',
            [
                'paintings' => $paintings,
                'user' => $user
            ]
        );
    }
}
