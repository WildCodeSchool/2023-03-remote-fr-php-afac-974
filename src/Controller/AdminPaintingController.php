<?php

namespace App\Controller;

use App\Entity\Painting;
use App\Form\PaintingType;
use App\Repository\PaintingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use DateTimeImmutable;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/painting')]
#[IsGranted("ROLE_ADMIN")]
class AdminPaintingController extends AbstractController
{
    #[Route('/', name: 'app_admin_painting_index', methods: ['GET'])]
    public function index(
        PaintingRepository $paintingRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $paintingRepository->queryFindAll();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('admin_painting/index.html.twig', [
            'paintings' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_admin_painting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PaintingRepository $paintingRepository, SluggerInterface $slugger): Response
    {
        $painting = new Painting();
        $form = $this->createForm(PaintingType::class, $painting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($painting->getTitle());
            $painting->setSlug($slug);
            $painting->setCreatedAt(new DateTimeImmutable());
            $paintingRepository->save($painting, true);
            $this->addFlash('success', 'Une nouvelle oeuvre à été crée !');

            return $this->redirectToRoute('app_admin_painting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_painting/new.html.twig', [
            'painting' => $painting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_painting_show', methods: ['GET'])]
    public function show(Painting $painting): Response
    {
        return $this->render('admin_painting/show.html.twig', [
            'painting' => $painting,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_painting_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Painting $painting,
        PaintingRepository $paintingRepository,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(PaintingType::class, $painting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($painting->getTitle());
            $painting->setSlug($slug);
            $paintingRepository->save($painting, true);
            $this->addFlash('success', 'L\'oeuvre à bien été modifiée.');

            return $this->redirectToRoute('app_admin_painting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_painting/edit.html.twig', [
            'painting' => $painting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_painting_delete', methods: ['POST'])]
    public function delete(Request $request, Painting $painting, PaintingRepository $paintingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $painting->getId(), $request->request->get('_token'))) {
            $paintingRepository->remove($painting, true);
            $this->addFlash('danger', 'L\'oeuvre à bien été supprimée.');
        }

        return $this->redirectToRoute('app_admin_painting_index', [], Response::HTTP_SEE_OTHER);
    }
}
