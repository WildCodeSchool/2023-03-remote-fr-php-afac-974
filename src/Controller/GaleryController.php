<?php

namespace App\Controller;

use App\Repository\PaintingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

#[Route('/galery', name: 'galery_')]
class GaleryController extends AbstractController
{
    #[Route('/', name: 'index')]



    public function index(
        PaintingRepository $paintingRepositery,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $form = $this->createFormBuilder(null, [
            'method' => 'get',
            'csrf_protection' => false
        ])
            ->add('search', SearchType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $paintingRepositery->findLikeName($search);
        } else {
            $query = $paintingRepositery->queryFindAll();
        }
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('galery/index.html.twig', [
            'paintings' => $pagination,
            'form' => $form


        ]);
    }
}
