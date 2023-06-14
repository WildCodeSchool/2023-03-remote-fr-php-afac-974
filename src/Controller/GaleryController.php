<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/galery', name:'galery_')]
class GaleryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        PaintingRepository $paintingRepositery,
        PaginatorInterface $paginator,
        Request $request
        ): Response {
        $pagination = $paginator->paginate(
            $paintingRepositery->queryFindAll(),
            $request->query->getInt('page', 1),6
        );
        return $this->render('galery/index.html.twig', [
            'paintings' => $pagination,
        ]);

    }
}
