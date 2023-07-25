<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/artist')]
#[IsGranted('ROLE_ADMIN')]
class AdminArtistController extends AbstractController
{
    #[Route('/', name: 'app_admin_artist_index', methods: ['GET'])]
    public function index(ArtistRepository $artistRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $artistRepository->findAll();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('admin_artist/index.html.twig', [
            'artists' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_admin_artist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtistRepository $artistRepository, SluggerInterface $slugger): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($artist->getName());
            $artist->setSlug($slug);

            $artistRepository->save($artist, true);
            $this->addFlash('success', 'Un nouvel artiste à été crée !');
            return $this->redirectToRoute('app_admin_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_artist_show', methods: ['GET'])]
    public function show(Artist $artist): Response
    {
        return $this->render('admin_artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_artist_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Artist $artist,
        ArtistRepository $artistRepository,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($artist->getName());
            $artist->setSlug($slug);
            $artistRepository->save($artist, true);
            $this->addFlash('success', 'L\'artiste à bien été modifié.');
            return $this->redirectToRoute('app_admin_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_artist_delete', methods: ['POST'])]
    public function delete(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $request->request->get('_token'))) {
            $artistRepository->remove($artist, true);
            $this->addFlash('danger', 'L\'artiste à bien été supprimé.');
        }

        return $this->redirectToRoute('app_admin_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
